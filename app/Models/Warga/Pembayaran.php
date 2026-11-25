<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\KasBulanan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $warga = auth('warga')->user();

        $kas = KasBulanan::orderBy('tahun', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $kasTerbaru = $kas->first();

        $pembayaran = Pembayaran::where('warga_id', $warga->id)
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        $pembayaranTerbaru = $pembayaran->first();

        return view('warga.pembayaran.index', compact(
            'warga',
            'kas',
            'kasTerbaru',
            'pembayaran',
            'pembayaranTerbaru'
        ));
    }

    public function store(Request $request)
    {
        $warga = auth('warga')->user();

        $request->validate([
            'kas_bulanan_id' => 'required|exists:kas_bulanans,id',
            'metode_pembayaran' => 'required|in:transfer,tunai',
            'jumlah' => 'required|numeric|min:1',
            'bukti_transfer' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $kas = KasBulanan::findOrFail($request->kas_bulanan_id);

        // Hitung total pembayaran sebelumnya
        $totalSudahBayar = Pembayaran::where('warga_id', $warga->id)
            ->where('kas_bulanan_id', $kas->id)
            ->whereIn('status', [
                'Lunas',
                'Cicilan',
                'Menunggu Verifikasi',
                'Menunggu Konfirmasi',
            ])
            ->sum('jumlah');

        // Hitung sisa iuran
        $sisa = max(
            0,
            $kas->nominal - $totalSudahBayar
        );

        // Jangan boleh bayar melebihi sisa
        if ($request->jumlah > $sisa) {
            return back()
                ->withErrors([
                    'jumlah' => 'Nominal pembayaran melebihi sisa iuran.',
                ])
                ->withInput();
        }

        // Transfer wajib upload bukti
        if (
            $request->metode_pembayaran === 'transfer'
            && !$request->hasFile('bukti_transfer')
        ) {
            return back()
                ->withErrors([
                    'bukti_transfer' => 'Bukti transfer wajib diupload.',
                ])
                ->withInput();
        }

        // Upload bukti transfer
        $bukti = null;

        if ($request->hasFile('bukti_transfer')) {
            $bukti = $request->file('bukti_transfer')
                ->store('bukti-pembayaran', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | TENTUKAN JENIS PEMBAYARAN OTOMATIS
        |--------------------------------------------------------------------------
        |
        | Kalau jumlah bayar sama dengan sisa = Lunas
        | Kalau jumlah bayar kurang dari sisa = Cicilan
        |
        */

        if ((float) $request->jumlah >= (float) $sisa) {
            $jenisPembayaran = 'Lunas';
        } else {
            $jenisPembayaran = 'Cicilan';
        }

        // Tentukan status berdasarkan metode
        if ($request->metode_pembayaran === 'transfer') {
            $status = 'Menunggu Verifikasi';
        } else {
            $status = 'Menunggu Konfirmasi';
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        Pembayaran::create([
            'no_kk' => $warga->no_kk,
            'warga_id' => $warga->id,
            'kas_bulanan_id' => $kas->id,
            'tanggal_bayar' => now(),
            'jumlah' => $request->jumlah,
            'jenis_pembayaran' => $jenisPembayaran,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => $status,
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

    public function riwayat()
    {
        $warga = auth('warga')->user();

        $pembayaran = Pembayaran::with('kasBulanan')
            ->where('warga_id', $warga->id)
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        return view(
            'warga.riwayat.index',
            compact('warga', 'pembayaran')
        );
    }
}
