<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\KasBulanan;
use App\Models\Pembayaran;
use App\Models\Pemasukan;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengurusPembayaranController extends Controller
{
    /**
     * Daftar semua pembayaran
     */
    public function index()
    {
        $pembayarans = Pembayaran::with([
            'warga',
            'kasBulanan'
        ])
        ->latest('tanggal_bayar')
        ->get();

        return view(
            'pengurus.pembayaran.index',
            compact('pembayarans')
        );
    }


    /**
     * Halaman input pembayaran tunai
     */
    public function create()
    {
        // Ambil warga aktif
        $wargas = Warga::where('status', 'Aktif')
            ->orderBy('nama', 'asc')
            ->get();

        // Ambil semua kas bulanan
        $kas = KasBulanan::orderBy('tahun', 'asc')
            ->orderBy('id', 'asc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | AMBIL SEMUA PEMBAYARAN YANG MASIH DIHITUNG
        |--------------------------------------------------------------------------
        */

        $pembayarans = Pembayaran::select(
            'id',
            'warga_id',
            'no_kk',
            'kas_bulanan_id',
            'jumlah',
            'status',
            'metode_pembayaran'
        )
        ->whereIn('status', [
            'Lunas',
            'Cicilan',
            'Menunggu Verifikasi',
            'Menunggu Konfirmasi',
        ])
        ->get();


        /*
        |--------------------------------------------------------------------------
        | BUAT DATA PEMBAYARAN UNTUK JAVASCRIPT
        |--------------------------------------------------------------------------
        */

        $pembayaranData = [];


        foreach ($wargas as $warga) {

            $pembayaranData[$warga->id] = [];


            foreach ($kas as $kasBulanan) {

                $sudahDibayar = 0;


                /*
                |--------------------------------------------------------------------------
                | CARI PEMBAYARAN WARGA + KAS YANG SAMA
                |--------------------------------------------------------------------------
                */

                foreach ($pembayarans as $pembayaran) {

                    $wargaSama = false;


                    // Cocok berdasarkan warga_id
                    if (
                        !empty($pembayaran->warga_id) &&
                        (string) $pembayaran->warga_id ===
                        (string) $warga->id
                    ) {
                        $wargaSama = true;
                    }


                    // Jika warga_id tidak cocok,
                    // cocokkan berdasarkan nomor KK
                    if (
                        !$wargaSama &&
                        !empty($warga->no_kk) &&
                        !empty($pembayaran->no_kk) &&
                        (string) $pembayaran->no_kk ===
                        (string) $warga->no_kk
                    ) {
                        $wargaSama = true;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CEK KAS
                    |--------------------------------------------------------------------------
                    */

                    $kasSama =
                        (string) $pembayaran->kas_bulanan_id ===
                        (string) $kasBulanan->id;


                    /*
                    |--------------------------------------------------------------------------
                    | JIKA WARGA DAN KAS SAMA
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $wargaSama &&
                        $kasSama
                    ) {
                        $sudahDibayar +=
                            (float) $pembayaran->jumlah;
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | HITUNG NOMINAL DAN SISA
                |--------------------------------------------------------------------------
                */

                $nominal =
                    (float) $kasBulanan->nominal;


                $sisa =
                    max(
                        0,
                        $nominal - $sudahDibayar
                    );


                /*
                |--------------------------------------------------------------------------
                | SIMPAN DATA
                |--------------------------------------------------------------------------
                */

                $pembayaranData[$warga->id][$kasBulanan->id] = [
                    'nominal' => $nominal,
                    'sudah_dibayar' => $sudahDibayar,
                    'sisa' => $sisa,
                ];
            }
        }


        return view(
            'pengurus.pembayaran.create',
            compact(
                'wargas',
                'kas',
                'pembayaranData'
            )
        );
    }


    /**
     * Simpan pembayaran tunai
     */
    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => 'required|exists:warga,id',
            'kas_bulanan_id' => 'required|exists:kas_bulanans,id',
            'jumlah' => 'required|numeric|min:1000',
            'keterangan' => 'nullable|string|max:500',
        ]);


        /*
        |--------------------------------------------------------------------------
        | AMBIL WARGA DAN KAS
        |--------------------------------------------------------------------------
        */

        $warga = Warga::findOrFail(
            $request->warga_id
        );


        $kas = KasBulanan::findOrFail(
            $request->kas_bulanan_id
        );


        /*
        |--------------------------------------------------------------------------
        | HITUNG TOTAL YANG SUDAH DIBAYAR
        |--------------------------------------------------------------------------
        */

        $totalSudahBayar = Pembayaran::where(
            'kas_bulanan_id',
            $kas->id
        )
        ->where(function ($query) use ($warga) {

            $query
                ->where(
                    'warga_id',
                    $warga->id
                )
                ->orWhere(
                    'no_kk',
                    $warga->no_kk
                );

        })
        ->whereIn('status', [
            'Lunas',
            'Cicilan',
            'Menunggu Verifikasi',
            'Menunggu Konfirmasi',
        ])
        ->sum('jumlah');


        /*
        |--------------------------------------------------------------------------
        | HITUNG SISA
        |--------------------------------------------------------------------------
        */

        $nominal =
            (float) $kas->nominal;


        $sisa =
            max(
                0,
                $nominal - (float) $totalSudahBayar
            );


        /*
        |--------------------------------------------------------------------------
        | CEK SUDAH LUNAS
        |--------------------------------------------------------------------------
        */

        if ($sisa <= 0) {

            return back()
                ->withErrors([
                    'jumlah' =>
                        'Iuran bulan tersebut sudah lunas.'
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | CEK PEMBAYARAN MELEBIHI SISA
        |--------------------------------------------------------------------------
        */

        if (
            (float) $request->jumlah >
            $sisa
        ) {

            return back()
                ->withErrors([
                    'jumlah' =>
                        'Nominal pembayaran melebihi sisa iuran. ' .
                        'Sisa yang harus dibayar Rp ' .
                        number_format(
                            $sisa,
                            0,
                            ',',
                            '.'
                        )
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | TENTUKAN STATUS
        |--------------------------------------------------------------------------
        */

        if (
            (float) $request->jumlah >=
            $sisa
        ) {

            $jenisPembayaran = 'Lunas';
            $status = 'Lunas';

        } else {

            $jenisPembayaran = 'Cicilan';
            $status = 'Cicilan';

        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL PENGURUS YANG LOGIN
        |--------------------------------------------------------------------------
        */

        $pengurus =
            auth('pengurus')->user();


        $namaPengurus =
            $pengurus
                ? (
                    $pengurus->nama
                    ?? $pengurus->name
                    ?? 'Pengurus'
                )
                : 'Pengurus';


        /*
        |--------------------------------------------------------------------------
        | KETERANGAN
        |--------------------------------------------------------------------------
        */

        $keterangan =
            $request->keterangan;


        if ($keterangan) {

            $keterangan .=
                ' | ';

        }


        $keterangan .=
            'Diinput oleh: ' .
            $namaPengurus;


        /*
        |--------------------------------------------------------------------------
        | SIMPAN PEMBAYARAN DAN PEMASUKAN
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $request,
            $warga,
            $kas,
            $jenisPembayaran,
            $status,
            $namaPengurus,
            $keterangan
        ) {

            /*
            |--------------------------------------------------------------------------
            | SIMPAN PEMBAYARAN
            |--------------------------------------------------------------------------
            */

            $pembayaran = Pembayaran::create([

                'no_kk' =>
                    $warga->no_kk,

                'warga_id' =>
                    $warga->id,

                'kas_bulanan_id' =>
                    $kas->id,

                'tanggal_bayar' =>
                    now(),

                'jumlah' =>
                    $request->jumlah,

                'metode_pembayaran' =>
                    'Tunai',

                'jenis_pembayaran' =>
                    $jenisPembayaran,

                'status' =>
                    $status,

                // WAJIB pakai nama kolom database
                'bukti_transfer' =>
                    null,

                // Tunai tidak perlu diverifikasi
                'verified_by_role' =>
                    null,

                'verified_by_name' =>
                    null,

                'keterangan' =>
                    $keterangan,

            ]);


            /*
            |--------------------------------------------------------------------------
            | MASUKKAN KE PEMASUKAN
            |--------------------------------------------------------------------------
            */

            Pemasukan::create([

                'tanggal' =>
                    now(),

                'jumlah' =>
                    $request->jumlah,

                'sumber' =>
                    'Pembayaran Iuran Warga #' .
                    $pembayaran->id,

                'keterangan' =>
                    'Pembayaran iuran ' .
                    $kas->bulan .
                    ' ' .
                    $kas->tahun .
                    ' | Diinput oleh: ' .
                    $namaPengurus,

            ]);

        });


        return redirect()
            ->route(
                'pengurus.pembayaran.index'
            )
            ->with(
                'success',
                'Pembayaran tunai berhasil disimpan.'
            );
    }


    /**
     * Halaman detail verifikasi pembayaran transfer
     */
    public function showVerifikasi($id)
    {
        $pembayaran =
            Pembayaran::with([
                'warga',
                'kasBulanan'
            ])
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | HANYA TRANSFER
        |--------------------------------------------------------------------------
        */

        if (
            strtolower(
                trim(
                    $pembayaran->metode_pembayaran ?? ''
                )
            ) !== 'transfer'
        ) {

            return redirect()
                ->route(
                    'pengurus.pembayaran.index'
                )
                ->with(
                    'error',
                    'Hanya pembayaran transfer yang dapat diverifikasi.'
                );
        }


        return view(
            'pengurus.pembayaran.verifikasi',
            compact('pembayaran')
        );
    }


    /**
     * Proses verifikasi pembayaran transfer
     */
    public function verifikasi(
        Request $request,
        $id
    ) {

        $request->validate([
            'status' =>
                'required|in:Lunas,Cicilan,Ditolak',

            'keterangan_admin' =>
                'nullable|string|max:1000',
        ]);


        $pembayaran =
            Pembayaran::with([
                'warga',
                'kasBulanan'
            ])
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | CEK METODE PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        if (
            strtolower(
                trim(
                    $pembayaran->metode_pembayaran ?? ''
                )
            ) !== 'transfer'
        ) {

            return redirect()
                ->route(
                    'pengurus.pembayaran.index'
                )
                ->with(
                    'error',
                    'Pembayaran ini bukan pembayaran transfer.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CEK STATUS
        |--------------------------------------------------------------------------
        */

        if (
            !in_array(
                $pembayaran->status,
                [
                    'Menunggu Verifikasi',
                    'Menunggu Konfirmasi'
                ]
            )
        ) {

            return redirect()
                ->route(
                    'pengurus.pembayaran.index'
                )
                ->with(
                    'error',
                    'Pembayaran ini sudah diverifikasi.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL PENGURUS
        |--------------------------------------------------------------------------
        */

        $pengurus =
            auth('pengurus')->user();


        $namaPengurus =
            $pengurus
                ? (
                    $pengurus->nama
                    ?? $pengurus->name
                    ?? 'Pengurus'
                )
                : 'Pengurus';


        /*
        |--------------------------------------------------------------------------
        | KETERANGAN
        |--------------------------------------------------------------------------
        */

        $keterangan =
            $request->keterangan_admin
            ?: $pembayaran->keterangan;


        if ($keterangan) {

            $keterangan .=
                ' | ';

        }


        $keterangan .=
            'Diverifikasi oleh: ' .
            $namaPengurus;


        /*
        |--------------------------------------------------------------------------
        | SIMPAN PERUBAHAN
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $pembayaran,
            $request,
            $namaPengurus,
            $keterangan
        ) {

            $pembayaran->update([

                'status' =>
                    $request->status,

                'jenis_pembayaran' =>
                    $request->status !== 'Ditolak'
                        ? $request->status
                        : $pembayaran->jenis_pembayaran,

                'verified_by_role' =>
                    'Pengurus',

                'verified_by_name' =>
                    $namaPengurus,

                'keterangan' =>
                    $keterangan,

            ]);


            /*
            |--------------------------------------------------------------------------
            | JIKA DITERIMA, MASUKKAN KE PEMASUKAN
            |--------------------------------------------------------------------------
            */

            if (
                in_array(
                    $request->status,
                    [
                        'Lunas',
                        'Cicilan'
                    ]
                )
            ) {

                $sumber =
                    'Pembayaran Iuran Warga #' .
                    $pembayaran->id;


                /*
                |--------------------------------------------------------------------------
                | CEK AGAR TIDAK DUPLIKAT PEMASUKAN
                |--------------------------------------------------------------------------
                */

                $sudahAda =
                    Pemasukan::where(
                        'sumber',
                        $sumber
                    )->exists();


                if (!$sudahAda) {

                    Pemasukan::create([

                        'tanggal' =>
                            $pembayaran->tanggal_bayar,

                        'jumlah' =>
                            $pembayaran->jumlah,

                        'sumber' =>
                            $sumber,

                        'keterangan' =>
                            'Pembayaran iuran ' .
                            (
                                $pembayaran
                                    ->kasBulanan
                                    ->bulan
                                ?? ''
                            ) .
                            ' ' .
                            (
                                $pembayaran
                                    ->kasBulanan
                                    ->tahun
                                ?? ''
                            ) .
                            ' | Diverifikasi oleh: ' .
                            $namaPengurus,

                    ]);

                }

            }

        });


        return redirect()
            ->route(
                'pengurus.pembayaran.index'
            )
            ->with(
                'success',
                'Pembayaran berhasil diverifikasi oleh ' .
                $namaPengurus .
                '.'
            );
    }
}