<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Warga;
use App\Models\KasBulanan;
use App\Models\Pemasukan;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Menampilkan semua pembayaran
     */
    public function index()
    {
        $pembayaran = Pembayaran::with([
            'warga',
            'kasBulanan'
        ])
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        $warga = Warga::orderBy('nama', 'asc')->get();

        $kas = KasBulanan::orderBy('tahun', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view(
            'admin.pembayaran.index',
            compact(
                'pembayaran',
                'warga',
                'kas'
            )
        );
    }

    /**
     * Menampilkan detail pembayaran
     */
    public function show($id)
    {
        $pembayaran = Pembayaran::with([
            'warga',
            'kasBulanan'
        ])->findOrFail($id);

        return view(
            'admin.pembayaran.show',
            compact('pembayaran')
        );
    }

    /**
     * Verifikasi pembayaran dari warga oleh Admin
     */
    public function verifikasi(Request $request, $id)
    {
        $pembayaran = Pembayaran::with([
            'warga',
            'kasBulanan'
        ])->findOrFail($id);

        $request->validate([
            'status' => 'required|in:Lunas,Cicilan,Ditolak',
            'keterangan_admin' => 'nullable|string|max:500',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Simpan status dan data verifikasi
        |--------------------------------------------------------------------------
        */

        $pembayaran->update([
            'status' => $request->status,

            // Catat bahwa pembayaran diverifikasi oleh Admin
            'verified_by_role' => 'Admin',
            'verified_by_name' => 'Admin',

            'keterangan' => $request->keterangan_admin
                ?: $pembayaran->keterangan,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Jika pembayaran diterima, masukkan ke Pemasukan
        |--------------------------------------------------------------------------
        */

        if (in_array($request->status, ['Lunas', 'Cicilan'])) {

            $sudahAda = Pemasukan::where(
                'sumber',
                'Pembayaran Iuran Warga #' . $pembayaran->id
            )->exists();

            // Mencegah pemasukan dibuat dua kali
            if (!$sudahAda) {

                Pemasukan::create([
                    'tanggal' => $pembayaran->tanggal_bayar,

                    'sumber' =>
                        'Pembayaran Iuran Warga #' .
                        $pembayaran->id,

                    'jumlah' =>
                        $pembayaran->jumlah,

                    'keterangan' =>
                        'Pembayaran iuran warga ' .
                        ($pembayaran->warga->nama ?? '') .
                        ' - ' .
                        ($pembayaran->kasBulanan->bulan ?? '') .
                        ' ' .
                        ($pembayaran->kasBulanan->tahun ?? '') .
                        ' | Diverifikasi oleh: Admin',
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Kembali ke halaman pembayaran
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.pembayaran.index')
            ->with(
                'success',
                'Status pembayaran berhasil diperbarui dan diverifikasi oleh Admin.'
            );
    }

    /**
     * Input pembayaran tunai oleh Admin
     */
    public function storeTunai(Request $request)
    {
        $request->validate([
            'warga_id' =>
                'required|exists:warga,id',

            'kas_bulanan_id' =>
                'required|exists:kas_bulanans,id',

            'jumlah' =>
                'required|numeric|min:1',

            'keterangan' =>
                'nullable|string|max:500',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Ambil warga
        |--------------------------------------------------------------------------
        */

        $warga = Warga::findOrFail(
            $request->warga_id
        );

        /*
        |--------------------------------------------------------------------------
        | Ambil kas bulanan
        |--------------------------------------------------------------------------
        */

        $kas = KasBulanan::findOrFail(
            $request->kas_bulanan_id
        );

        /*
        |--------------------------------------------------------------------------
        | Hitung pembayaran sebelumnya
        |--------------------------------------------------------------------------
        */

        $totalSudahBayar = Pembayaran::where(
            'warga_id',
            $warga->id
        )
            ->where(
                'kas_bulanan_id',
                $kas->id
            )
            ->whereIn('status', [
                'Lunas',
                'Cicilan',
                'Menunggu Verifikasi',
                'Menunggu Konfirmasi',
            ])
            ->sum('jumlah');

        /*
        |--------------------------------------------------------------------------
        | Hitung sisa iuran
        |--------------------------------------------------------------------------
        */

        $sisa = max(
            0,
            (float) $kas->nominal -
            (float) $totalSudahBayar
        );

        /*
        |--------------------------------------------------------------------------
        | Jika sudah lunas
        |--------------------------------------------------------------------------
        */

        if ($sisa <= 0) {

            return back()
                ->withErrors([
                    'jumlah' =>
                        'Iuran warga untuk bulan tersebut sudah lunas.'
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Cek jumlah pembayaran
        |--------------------------------------------------------------------------
        */

        if (
            (float) $request->jumlah >
            $sisa
        ) {

            return back()
                ->withErrors([
                    'jumlah' =>
                        'Pembayaran melebihi sisa iuran. ' .
                        'Sisa pembayaran: Rp ' .
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
        | Tentukan jenis pembayaran
        |--------------------------------------------------------------------------
        */

        if (
            (float) $request->jumlah >=
            $sisa
        ) {

            $jenisPembayaran = 'Lunas';

        } else {

            $jenisPembayaran = 'Cicilan';
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan pembayaran tunai
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

            'jenis_pembayaran' =>
                $jenisPembayaran,

            'metode_pembayaran' =>
                'Tunai',

            'status' =>
                $jenisPembayaran,

            'bukti_pembayaran' =>
                null,

            'keterangan' =>
                $request->keterangan,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Simpan otomatis ke pemasukan
        |--------------------------------------------------------------------------
        */

        Pemasukan::create([
            'tanggal' =>
                $pembayaran->tanggal_bayar,

            'sumber' =>
                'Pembayaran Iuran Warga #' .
                $pembayaran->id,

            'jumlah' =>
                $pembayaran->jumlah,

            'keterangan' =>
                'Pembayaran tunai iuran warga ' .
                $warga->nama .
                ' - ' .
                $kas->bulan .
                ' ' .
                $kas->tahun .
                (
                    $request->keterangan
                        ? ' - ' . $request->keterangan
                        : ''
                ),
        ]);

        return redirect()
            ->route('admin.pembayaran.index')
            ->with(
                'success',
                'Pembayaran tunai berhasil dicatat dan otomatis masuk ke pemasukan.'
            );
    }

    /**
     * Hapus pembayaran
     */
    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Hapus pemasukan yang berhubungan
        |--------------------------------------------------------------------------
        */

        Pemasukan::where(
            'sumber',
            'Pembayaran Iuran Warga #' .
            $pembayaran->id
        )->delete();

        /*
        |--------------------------------------------------------------------------
        | Hapus pembayaran
        |--------------------------------------------------------------------------
        */

        $pembayaran->delete();

        return back()->with(
            'success',
            'Data pembayaran berhasil dihapus.'
        );
    }
}