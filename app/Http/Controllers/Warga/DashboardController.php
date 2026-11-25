<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * DASHBOARD WARGA
     */
    public function index()
    {
        // Ambil warga yang sedang login
        $warga = Auth::guard('warga')->user();

        // Riwayat pembayaran warga
        $pembayaran = Pembayaran::where('no_kk', $warga->no_kk)
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        // Pembayaran terakhir
        $pembayaranTerakhir = $pembayaran->first();

        // Total pemasukan
        $totalPemasukan = Pemasukan::sum('jumlah');

        // Total pengeluaran
        $totalPengeluaran = Pengeluaran::sum('jumlah');

        // Saldo
        $saldo = $totalPemasukan - $totalPengeluaran;

        // Pengumuman terbaru
        $pengumuman = Pengumuman::latest()
            ->take(5)
            ->get();

        return view('warga.dashboard', compact(
            'warga',
            'pembayaran',
            'pembayaranTerakhir',
            'totalPemasukan',
            'totalPengeluaran',
            'saldo',
            'pengumuman'
        ));
    }
}