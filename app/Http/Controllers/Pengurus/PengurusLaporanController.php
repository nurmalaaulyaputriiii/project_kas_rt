<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class PengurusLaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // =========================
        // PEMASUKAN
        // =========================
        $pemasukanQuery = Pemasukan::query();

        if (!empty($bulan)) {
            $pemasukanQuery->whereMonth('tanggal', $bulan);
        }

        if (!empty($tahun)) {
            $pemasukanQuery->whereYear('tanggal', $tahun);
        }

        $pemasukan = $pemasukanQuery
            ->orderBy('tanggal', 'asc')
            ->get();

        // =========================
        // PENGELUARAN
        // =========================
        $pengeluaranQuery = Pengeluaran::query();

        if (!empty($bulan)) {
            $pengeluaranQuery->whereMonth('tanggal', $bulan);
        }

        if (!empty($tahun)) {
            $pengeluaranQuery->whereYear('tanggal', $tahun);
        }

        $pengeluaran = $pengeluaranQuery
            ->orderBy('tanggal', 'asc')
            ->get();

        // =========================
        // TOTAL
        // =========================
        $totalPemasukan = $pemasukan->sum('jumlah');

        $totalPengeluaran = $pengeluaran->sum('jumlah');

        $saldo = $totalPemasukan - $totalPengeluaran;

        return view(
            'pengurus.laporan',
            compact(
                'pemasukan',
                'pengeluaran',
                'totalPemasukan',
                'totalPengeluaran',
                'saldo',
                'bulan',
                'tahun'
            )
        );
    }

    public function cetak(Request $request)
    {
        return $this->index($request);
    }
}