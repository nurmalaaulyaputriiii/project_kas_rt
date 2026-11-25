<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLER ADMIN
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\Admin\KasBulananController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\PemasukanController;
use App\Http\Controllers\Admin\PengeluaranController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PengurusController;


/*
|--------------------------------------------------------------------------
| CONTROLLER WARGA
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use App\Http\Controllers\Warga\PembayaranController as WargaPembayaranController;
use App\Http\Controllers\Warga\LaporanPengeluaranController;


/*
|--------------------------------------------------------------------------
| CONTROLLER AUTH
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\WargaLoginController;
use App\Http\Controllers\Auth\WargaRegisterController;
use App\Http\Controllers\Auth\PengurusLoginController;


/*
|--------------------------------------------------------------------------
| CONTROLLER PENGURUS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Pengurus\PengurusDashboardController;
use App\Http\Controllers\Pengurus\PengurusPembayaranController;
use App\Http\Controllers\Pengurus\PengurusPemasukanController;
use App\Http\Controllers\Pengurus\PengurusPengeluaranController;
use App\Http\Controllers\Pengurus\PengurusPengumumanController;
use App\Http\Controllers\Pengurus\PengurusWargaController;
use App\Http\Controllers\Pengurus\PengurusLaporanController;


/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('warga.login');
});


/*
|--------------------------------------------------------------------------
| LOGIN ADMIN
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [
    AdminLoginController::class,
    'showLoginForm'
])->name('admin.login');

Route::post('/admin/login', [
    AdminLoginController::class,
    'login'
])->name('admin.login.post');


/*
|--------------------------------------------------------------------------
| LOGOUT ADMIN
|--------------------------------------------------------------------------
*/

Route::post('/admin/logout', [
    AdminLoginController::class,
    'logout'
])->name('admin.logout');


/*
|--------------------------------------------------------------------------
| LOGIN WARGA
|--------------------------------------------------------------------------
*/

Route::get('/warga/login', [
    WargaLoginController::class,
    'showLoginForm'
])->name('warga.login');

Route::post('/warga/login', [
    WargaLoginController::class,
    'login'
])->name('warga.login.post');


/*
|--------------------------------------------------------------------------
| LOGIN PENGURUS
|--------------------------------------------------------------------------
*/

Route::get('/pengurus/login', [
    PengurusLoginController::class,
    'showLoginForm'
])->name('pengurus.login');

Route::post('/pengurus/login', [
    PengurusLoginController::class,
    'login'
])->name('pengurus.login.post');


/*
|--------------------------------------------------------------------------
| LOGIN DEFAULT
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return redirect()->route('warga.login');
})->name('login');


/*
|--------------------------------------------------------------------------
| REGISTER WARGA
|--------------------------------------------------------------------------
*/

Route::get('/warga/register', [
    WargaRegisterController::class,
    'showRegistrationForm'
])->name('warga.register');

Route::post('/warga/register', [
    WargaRegisterController::class,
    'register'
])->name('warga.register.post');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard Admin
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            AdminDashboardController::class,
            'index'
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Data Warga
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'warga',
            WargaController::class
        );


        /*
        |--------------------------------------------------------------------------
        | Kelola Pengurus / Petugas
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'pengurus',
            PengurusController::class
        );


        /*
        |--------------------------------------------------------------------------
        | Kas Bulanan
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'kas',
            KasBulananController::class
        );


        /*
        |--------------------------------------------------------------------------
        | Pembayaran Iuran
        |--------------------------------------------------------------------------
        */

        Route::post('/pembayaran/tunai', [
            PembayaranController::class,
            'storeTunai'
        ])->name('pembayaran.tunai.store');

        Route::resource(
            'pembayaran',
            PembayaranController::class
        );


        /*
        |--------------------------------------------------------------------------
        | Verifikasi Pembayaran Admin
        |--------------------------------------------------------------------------
        */

        Route::patch('/pembayaran/{pembayaran}/verifikasi', [
            PembayaranController::class,
            'verifikasi'
        ])->name('pembayaran.verifikasi');


        /*
        |--------------------------------------------------------------------------
        | Pemasukan
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'pemasukan',
            PemasukanController::class
        );


        /*
        |--------------------------------------------------------------------------
        | Pengeluaran
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'pengeluaran',
            PengeluaranController::class
        );


        /*
        |--------------------------------------------------------------------------
        | Laporan Admin
        |--------------------------------------------------------------------------
        */

        Route::get('/laporan', [
            LaporanController::class,
            'index'
        ])->name('laporan');


        /*
        |--------------------------------------------------------------------------
        | Pengumuman
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'pengumuman',
            PengumumanController::class
        );


        /*
        |--------------------------------------------------------------------------
        | Profil Admin
        |--------------------------------------------------------------------------
        */

        Route::get('/profil', function () {

            $admin = auth()->user();

            return view(
                'admin.profil',
                compact('admin')
            );

        })->name('profil');

    });


/*
|--------------------------------------------------------------------------
| WARGA
|--------------------------------------------------------------------------
*/

Route::prefix('warga')
    ->name('warga.')
    ->middleware('auth:warga')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard Warga
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            WargaDashboardController::class,
            'index'
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Pembayaran Iuran
        |--------------------------------------------------------------------------
        */

        Route::get('/pembayaran', [
            WargaPembayaranController::class,
            'index'
        ])->name('pembayaran');

        Route::post('/pembayaran', [
            WargaPembayaranController::class,
            'store'
        ])->name('pembayaran.store');


        /*
        |--------------------------------------------------------------------------
        | Riwayat Pembayaran
        |--------------------------------------------------------------------------
        */

        Route::get('/riwayat', [
            WargaPembayaranController::class,
            'riwayat'
        ])->name('riwayat');


        /*
        |--------------------------------------------------------------------------
        | Laporan Pengeluaran Warga
        |--------------------------------------------------------------------------
        */

        Route::get('/laporan-pengeluaran', [
            LaporanPengeluaranController::class,
            'index'
        ])->name('laporan.pengeluaran');


        /*
        |--------------------------------------------------------------------------
        | Pengumuman
        |--------------------------------------------------------------------------
        */

        Route::get('/pengumuman', function () {

            $pengumuman = \App\Models\Pengumuman::orderBy(
                'created_at',
                'desc'
            )->get();

            return view(
                'warga.pengumuman.index',
                compact('pengumuman')
            );

        })->name('pengumuman');


        /*
        |--------------------------------------------------------------------------
        | Profil Warga
        |--------------------------------------------------------------------------
        */

        Route::get('/profil', function () {

            $warga = auth('warga')->user();

            return view(
                'warga.profil.index',
                compact('warga')
            );

        })->name('profil');


        /*
        |--------------------------------------------------------------------------
        | Logout Warga
        |--------------------------------------------------------------------------
        */

        Route::post('/logout', [
            WargaLoginController::class,
            'logout'
        ])->name('logout');

    });


/*
|--------------------------------------------------------------------------
| PENGURUS
|--------------------------------------------------------------------------
*/

Route::prefix('pengurus')
    ->name('pengurus.')
    ->middleware('auth:pengurus')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard Pengurus
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            PengurusDashboardController::class,
            'index'
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        Route::get('/pembayaran', [
            PengurusPembayaranController::class,
            'index'
        ])->name('pembayaran.index');


        /*
        |--------------------------------------------------------------------------
        | Input Pembayaran Tunai
        |--------------------------------------------------------------------------
        */

        Route::get('/pembayaran/create', [
            PengurusPembayaranController::class,
            'create'
        ])->name('pembayaran.create');

        Route::post('/pembayaran', [
            PengurusPembayaranController::class,
            'store'
        ])->name('pembayaran.store');


        /*
        |--------------------------------------------------------------------------
        | Verifikasi Pembayaran Transfer Pengurus
        |--------------------------------------------------------------------------
        |
        | GET   = membuka halaman detail verifikasi
        | PATCH = memproses hasil verifikasi
        |
        */

        Route::get('/pembayaran/{pembayaran}/verifikasi', [
            PengurusPembayaranController::class,
            'showVerifikasi'
        ])->name('pembayaran.verifikasi');

        Route::patch('/pembayaran/{pembayaran}/verifikasi', [
            PengurusPembayaranController::class,
            'verifikasi'
        ])->name('pembayaran.verifikasi.proses');


        /*
        |--------------------------------------------------------------------------
        | PEMASUKAN
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'pemasukan',
            PengurusPemasukanController::class
        );


        /*
        |--------------------------------------------------------------------------
        | PENGELUARAN
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'pengeluaran',
            PengurusPengeluaranController::class
        );


        /*
        |--------------------------------------------------------------------------
        | PENGUMUMAN
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'pengumuman',
            PengurusPengumumanController::class
        )->except([
            'show'
        ]);


        /*
        |--------------------------------------------------------------------------
        | DATA WARGA
        |--------------------------------------------------------------------------
        | Hanya bisa melihat
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'warga',
            PengurusWargaController::class
        )->only([
            'index',
            'show'
        ]);


        /*
        |--------------------------------------------------------------------------
        | LAPORAN PENGURUS
        |--------------------------------------------------------------------------
        */

        Route::get('/laporan', [
            PengurusLaporanController::class,
            'index'
        ])->name('laporan');


        /*
        |--------------------------------------------------------------------------
        | Cetak Laporan Pengurus
        |--------------------------------------------------------------------------
        */

        Route::get('/laporan/cetak', [
            PengurusLaporanController::class,
            'cetak'
        ])->name('laporan.cetak');


        /*
        |--------------------------------------------------------------------------
        | Profil Pengurus
        |--------------------------------------------------------------------------
        */

        Route::get('/profil', function () {

            $pengurus = auth('pengurus')->user();

            return view(
                'pengurus.profil.index',
                compact('pengurus')
            );

        })->name('profil');


        /*
        |--------------------------------------------------------------------------
        | Logout Pengurus
        |--------------------------------------------------------------------------
        */

        Route::post('/logout', [
            PengurusLoginController::class,
            'logout'
        ])->name('logout');

    });