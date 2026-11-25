<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use App\Models\Pemasukan;
use Illuminate\Http\Request;

class LaporanPengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $warga = auth('warga')->user();

        // =========================
        // FILTER
        // =========================
        $search = $request->search;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // =========================
        // DATA PENGELUARAN
        // =========================
        $query = Pengeluaran::query();

        // Filter pencarian
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('keperluan', 'like', '%' . $search . '%')
                  ->orWhere('keterangan', 'like', '%' . $search . '%');
            });
        }

        // Filter bulan
        if (!empty($bulan)) {
            $query->whereMonth('tanggal', $bulan);
        }

        // Filter tahun
        if (!empty($tahun)) {
            $query->whereYear('tanggal', $tahun);
        }

        // Ambil data pengeluaran
        $pengeluaran = $query
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        // Total pengeluaran sesuai filter
        $totalPengeluaran = $pengeluaran->sum('jumlah');

        // Jumlah transaksi sesuai filter
        $jumlahTransaksi = $pengeluaran->count();

        // =========================
        // DATA PEMASUKAN
        // =========================
        $pemasukanQuery = Pemasukan::query();

        // Filter bulan
        if (!empty($bulan)) {
            $pemasukanQuery->whereMonth('tanggal', $bulan);
        }

        // Filter tahun
        if (!empty($tahun)) {
            $pemasukanQuery->whereYear('tanggal', $tahun);
        }

        // Ambil data pemasukan
        $pemasukan = $pemasukanQuery
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        // Total pemasukan sesuai filter
        $totalPemasukan = $pemasukan->sum('jumlah');

        // =========================
        // SALDO
        // =========================
        $saldo = $totalPemasukan - $totalPengeluaran;

        // =========================
        // TAHUN YANG TERSEDIA
        // =========================
        $tahunList = Pengeluaran::selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Tambahkan tahun dari pemasukan jika belum ada
        $tahunPemasukan = Pemasukan::selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->pluck('tahun');

        $tahunList = $tahunList
            ->merge($tahunPemasukan)
            ->unique()
            ->sortDesc()
            ->values();

        // =========================
        // KIRIM KE VIEW
        // =========================
        return view(
            'warga.laporan-pengeluaran.index',
            compact(
                'warga',
                'pemasukan',
                'pengeluaran',
                'totalPemasukan',
                'totalPengeluaran',
                'saldo',
                'jumlahTransaksi',
                'search',
                'bulan',
                'tahun',
                'tahunList'
            )
        );
    }
}