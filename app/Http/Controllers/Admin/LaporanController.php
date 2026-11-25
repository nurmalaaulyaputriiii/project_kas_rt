<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->filled('bulan')
            ? (int) $request->bulan
            : now()->month;

        $tahun = $request->filled('tahun')
            ? (int) $request->tahun
            : now()->year;

        // DATA PEMASUKAN
        $pemasukan = Pemasukan::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        // DATA PENGELUARAN
        $pengeluaran = Pengeluaran::orderBy('tanggal', 'asc')->get();

        // TOTAL
        $totalPemasukan = $pemasukan->sum('jumlah');
        $totalPengeluaran = $pengeluaran->sum('jumlah');

        // SALDO
        $saldo = $totalPemasukan - $totalPengeluaran;

        return view('admin.laporan', compact(
            'pemasukan',
            'pengeluaran',
            'totalPemasukan',
            'totalPengeluaran',
            'saldo',
            'bulan',
            'tahun'
        ));
    }

    public function cetak(Request $request)
    {
        return $this->index($request);
    }
}