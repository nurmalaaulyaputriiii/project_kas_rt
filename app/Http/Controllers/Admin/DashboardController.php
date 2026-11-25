<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\KasBulanan;

class DashboardController extends Controller
{
    public function index()
    {
        // JUMLAH WARGA AKTIF
        $jumlahWarga = Warga::where('status', 'Aktif')->count();

        // TOTAL SEMUA PEMASUKAN
        $totalPemasukan = Pemasukan::sum('jumlah');

        // TOTAL SEMUA PENGELUARAN
        $totalPengeluaran = Pengeluaran::sum('jumlah');

        // SALDO SEMUA KAS
        $saldo = $totalPemasukan - $totalPengeluaran;

        // TOTAL IURAN BULANAN
        $iuranBulanan = KasBulanan::sum('nominal');

        // BULAN & TAHUN SEKARANG
        $bulan = now()->month;
        $tahun = now()->year;

        // PEMASUKAN BULAN INI
        $pemasukanBulanIni = Pemasukan::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');

        // PENGELUARAN BULAN INI
        $pengeluaranBulanIni = Pengeluaran::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');

        // SALDO BULAN INI
        $saldoBulanIni = $pemasukanBulanIni - $pengeluaranBulanIni;

        // DATA GRAFIK 12 BULAN
        $grafikPemasukan = [];
        $grafikPengeluaran = [];

        for ($i = 1; $i <= 12; $i++) {

            $grafikPemasukan[] = Pemasukan::whereMonth('tanggal', $i)
                ->whereYear('tanggal', $tahun)
                ->sum('jumlah');

            $grafikPengeluaran[] = Pengeluaran::whereMonth('tanggal', $i)
                ->whereYear('tanggal', $tahun)
                ->sum('jumlah');
        }

        return view('admin.dashboard', compact(
            'jumlahWarga',
            'totalPemasukan',
            'totalPengeluaran',
            'saldo',
            'iuranBulanan',
            'pemasukanBulanIni',
            'pengeluaranBulanIni',
            'saldoBulanIni',
            'grafikPemasukan',
            'grafikPengeluaran'
        ));
    }
}