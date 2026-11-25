<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\KasBulanan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Halaman pembayaran warga
     */
    public function index()
    {
        $warga = auth('warga')->user();

        $daftarBulan = [
            'Januari' => 1,
            'Februari' => 2,
            'Maret' => 3,
            'April' => 4,
            'Mei' => 5,
            'Juni' => 6,
            'Juli' => 7,
            'Agustus' => 8,
            'September' => 9,
            'Oktober' => 10,
            'November' => 11,
            'Desember' => 12,
        ];

        /*
        |--------------------------------------------------------------------------
        | TENTUKAN BULAN MULAI WARGA WAJIB BAYAR
        |--------------------------------------------------------------------------
        */

        if ($warga->tanggal_daftar) {
            $tanggalMulai = $warga->tanggal_daftar->copy()->startOfMonth();
        } else {
            /*
             * Untuk data warga lama yang belum memiliki tanggal_daftar,
             * sementara gunakan bulan sekarang agar tidak tiba-tiba
             * muncul seluruh tunggakan lama.
             */
            $tanggalMulai = now()->copy()->startOfMonth();
        }

        $tanggalSekarang = now()->copy()->startOfMonth();


        /*
        |--------------------------------------------------------------------------
        | AMBIL KAS BULANAN
        |--------------------------------------------------------------------------
        */

        $semuaKas = KasBulanan::orderBy('tahun', 'asc')
            ->orderBy('id', 'asc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | FILTER KAS
        |--------------------------------------------------------------------------
        |
        | Hanya:
        | - mulai dari bulan warga terdaftar
        | - sampai bulan sekarang
        |
        */

        $daftarKas = collect();

        foreach ($semuaKas as $kas) {

            $nomorBulan = $daftarBulan[$kas->bulan] ?? 0;

            if ($nomorBulan === 0) {
                continue;
            }

            try {
                $tanggalKas = now()
                    ->setDate(
                        (int) $kas->tahun,
                        $nomorBulan,
                        1
                    )
                    ->startOfMonth();
            } catch (\Throwable $e) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | JANGAN TAMPILKAN BULAN SEBELUM WARGA TERDAFTAR
            |--------------------------------------------------------------------------
            */

            if ($tanggalKas->lt($tanggalMulai)) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | JANGAN TAMPILKAN BULAN YANG BELUM TIBA
            |--------------------------------------------------------------------------
            */

            if ($tanggalKas->gt($tanggalSekarang)) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | HITUNG PEMBAYARAN WARGA
            |--------------------------------------------------------------------------
            */

            $totalBayar = Pembayaran::where('kas_bulanan_id', $kas->id)
                ->where(function ($query) use ($warga) {
                    $query->where('warga_id', $warga->id)
                        ->orWhere('no_kk', $warga->no_kk);
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

            $nominalKas = (float) $kas->nominal;

            $sisaBayar = max(
                0,
                $nominalKas - (float) $totalBayar
            );


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            if ($totalBayar >= $nominalKas) {

                $statusBayar = 'Lunas';

            } elseif ($totalBayar > 0) {

                $statusBayar = 'Cicilan';

            } else {

                $statusBayar = 'Belum Bayar';
            }


            $daftarKas->push([
                'kas' => $kas,
                'nomor_bulan' => $nomorBulan,
                'total_bayar' => $totalBayar,
                'sisa_bayar' => $sisaBayar,
                'status' => $statusBayar,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | URUTKAN DARI TERLAMA KE TERBARU
        |--------------------------------------------------------------------------
        */

        $daftarKas = $daftarKas
            ->sortBy(function ($item) {
                return ($item['kas']->tahun * 100)
                    + $item['nomor_bulan'];
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | YANG BELUM LUNAS
        |--------------------------------------------------------------------------
        */

        $kasBelumLunas = $daftarKas->filter(function ($item) {
            return $item['sisa_bayar'] > 0;
        })->values();


        /*
        |--------------------------------------------------------------------------
        | TOTAL TUNGGAKAN
        |--------------------------------------------------------------------------
        */

        $totalTunggakan = $kasBelumLunas->sum('sisa_bayar');


        /*
        |--------------------------------------------------------------------------
        | YANG SUDAH LUNAS
        |--------------------------------------------------------------------------
        */

        $kasLunas = $daftarKas->filter(function ($item) {
            return $item['status'] === 'Lunas';
        })->values();


        /*
        |--------------------------------------------------------------------------
        | RIWAYAT PEMBAYARAN TERBARU
        |--------------------------------------------------------------------------
        */

        $pembayaran = Pembayaran::with('kasBulanan')
            ->where(function ($query) use ($warga) {
                $query->where('warga_id', $warga->id)
                    ->orWhere('no_kk', $warga->no_kk);
            })
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        $pembayaranTerbaru = $pembayaran->first();


        /*
        |--------------------------------------------------------------------------
        | KAS TERBARU
        |--------------------------------------------------------------------------
        */

        $kasTerbaru = $daftarKas->last()['kas'] ?? null;


        return view('warga.pembayaran.index', compact(
            'warga',
            'daftarKas',
            'kasBelumLunas',
            'kasLunas',
            'totalTunggakan',
            'pembayaran',
            'pembayaranTerbaru',
            'kasTerbaru'
        ));
    }


    /**
     * Simpan pembayaran warga
     */
    public function store(Request $request)
    {
        $warga = auth('warga')->user();

        $request->validate([
            'kas_bulanan_id' => 'required|exists:kas_bulanans,id',
            'metode_pembayaran' => 'required|in:Transfer',
            'jumlah' => 'required|numeric|min:1000',
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string|max:500',
        ]);


        $kas = KasBulanan::findOrFail(
            $request->kas_bulanan_id
        );


        /*
        |--------------------------------------------------------------------------
        | CEK BULAN TIDAK BOLEH SEBELUM TANGGAL DAFTAR
        |--------------------------------------------------------------------------
        */

        if ($warga->tanggal_daftar) {

            $daftarBulan = [
                'Januari' => 1,
                'Februari' => 2,
                'Maret' => 3,
                'April' => 4,
                'Mei' => 5,
                'Juni' => 6,
                'Juli' => 7,
                'Agustus' => 8,
                'September' => 9,
                'Oktober' => 10,
                'November' => 11,
                'Desember' => 12,
            ];

            $nomorBulanKas = $daftarBulan[$kas->bulan] ?? 0;

            if ($nomorBulanKas === 0) {
                return back()
                    ->withErrors([
                        'kas_bulanan_id' => 'Bulan iuran tidak valid.',
                    ])
                    ->withInput();
            }

            $tanggalKas = now()->setDate(
                (int) $kas->tahun,
                $nomorBulanKas,
                1
            )->startOfMonth();

            $tanggalMulai = $warga->tanggal_daftar
                ->copy()
                ->startOfMonth();

            if ($tanggalKas->lt($tanggalMulai)) {
                return back()
                    ->withErrors([
                        'kas_bulanan_id' =>
                            'Iuran sebelum bulan pendaftaran tidak perlu dibayar.',
                    ])
                    ->withInput();
            }
        }


        /*
        |--------------------------------------------------------------------------
        | HITUNG SEMUA PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        $totalSudahBayar = Pembayaran::where(
            'kas_bulanan_id',
            $kas->id
        )
            ->where(function ($query) use ($warga) {
                $query->where('warga_id', $warga->id)
                    ->orWhere('no_kk', $warga->no_kk);
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

        $sisa = max(
            0,
            (float) $kas->nominal - (float) $totalSudahBayar
        );


        /*
        |--------------------------------------------------------------------------
        | SUDAH LUNAS
        |--------------------------------------------------------------------------
        */

        if ($sisa <= 0) {

            return back()
                ->withErrors([
                    'jumlah' => 'Iuran bulan tersebut sudah lunas.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | JUMLAH TIDAK BOLEH MELEBIHI SISA
        |--------------------------------------------------------------------------
        */

        if ((float) $request->jumlah > $sisa) {

            return back()
                ->withErrors([
                    'jumlah' =>
                        'Nominal pembayaran melebihi sisa iuran. ' .
                        'Sisa yang harus dibayar Rp ' .
                        number_format($sisa, 0, ',', '.'),
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | UPLOAD BUKTI TRANSFER
        |--------------------------------------------------------------------------
        */

        $bukti = $request
            ->file('bukti_pembayaran')
            ->store('bukti-pembayaran', 'public');


        /*
        |--------------------------------------------------------------------------
        | JENIS PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        if ((float) $request->jumlah >= $sisa) {

            $jenisPembayaran = 'Lunas';

        } else {

            $jenisPembayaran = 'Cicilan';
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN
        |--------------------------------------------------------------------------
        */

        Pembayaran::create([
            'no_kk' => $warga->no_kk,
            'warga_id' => $warga->id,
            'kas_bulanan_id' => $kas->id,
            'tanggal_bayar' => now(),
            'jumlah' => $request->jumlah,
            'jenis_pembayaran' => $jenisPembayaran,
            'metode_pembayaran' => 'Transfer',
            'status' => 'Menunggu Verifikasi',
            'bukti_transfer' => $bukti,
            'keterangan' => $request->keterangan,
        ]);


        return redirect()
            ->route('warga.pembayaran')
            ->with(
                'success',
                'Pembayaran berhasil dikirim. Menunggu verifikasi admin.'
            );
    }


    /**
     * Riwayat pembayaran warga
     */
    public function riwayat()
    {
        $warga = auth('warga')->user();

        $pembayaran = Pembayaran::with('kasBulanan')
            ->where(function ($query) use ($warga) {
                $query->where('warga_id', $warga->id)
                    ->orWhere('no_kk', $warga->no_kk);
            })
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        return view(
            'warga.riwayat.index',
            compact('warga', 'pembayaran')
        );
    }
}