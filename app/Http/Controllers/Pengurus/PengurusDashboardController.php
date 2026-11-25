<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\Auth;

class PengurusDashboardController extends Controller
{
    public function index()
    {
        $pengurus = Auth::guard('pengurus')->user();

        $bulan = now()->month;
        $tahun = now()->year;

        /*
        |--------------------------------------------------------------------------
        | TOTAL PEMASUKAN
        |--------------------------------------------------------------------------
        */

        $totalPemasukan = Pemasukan::sum('jumlah');


        /*
        |--------------------------------------------------------------------------
        | TOTAL PENGELUARAN
        |--------------------------------------------------------------------------
        */

        $totalPengeluaran = Pengeluaran::sum('jumlah');


        /*
        |--------------------------------------------------------------------------
        | SALDO KAS
        |--------------------------------------------------------------------------
        */

        $saldoKas = $totalPemasukan - $totalPengeluaran;


        /*
        |--------------------------------------------------------------------------
        | KAS MASUK BULAN INI
        |--------------------------------------------------------------------------
        */

        $kasMasukBulanIni = Pemasukan::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');


        /*
        |--------------------------------------------------------------------------
        | JUMLAH WARGA AKTIF
        |--------------------------------------------------------------------------
        */

        $jumlahWarga = Warga::where('status', 'Aktif')->count();


        /*
        |--------------------------------------------------------------------------
        | KAS MASUK TERBARU
        |--------------------------------------------------------------------------
        */

        $kasMasukTerbaru = Pemasukan::latest('tanggal')
            ->take(8)
            ->get();


        return view('pengurus.dashboard', compact(
            'pengurus',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoKas',
            'kasMasukBulanIni',
            'jumlahWarga',
            'kasMasukTerbaru'
        ));
    }
}