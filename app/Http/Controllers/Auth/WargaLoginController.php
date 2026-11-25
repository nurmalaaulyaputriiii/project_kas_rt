<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WargaLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.warga-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'no_kk' => 'required|string|size:16',
            'password' => 'required|string',
        ], [
            'no_kk.required' => 'Nomor KK wajib diisi.',
            'no_kk.size' => 'Nomor KK harus 16 digit.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $warga = Warga::where('no_kk', $request->no_kk)
            ->where('status', 'Aktif')
            ->first();

        if (!$warga) {
            return back()
                ->withErrors([
                    'no_kk' => 'Nomor KK belum terdaftar atau tidak aktif.',
                ])
                ->withInput();
        }

        if (!$warga->password) {
            return back()
                ->withErrors([
                    'no_kk' => 'Akun belum memiliki password. Silakan daftar terlebih dahulu.',
                ])
                ->withInput();
        }

        if (!Hash::check($request->password, $warga->password)) {
            return back()
                ->withErrors([
                    'password' => 'Password salah.',
                ])
                ->withInput();
        }

        // LOGIN WARGA
        // Jangan logout admin/pengurus karena semua tab memakai session browser yang sama.
        Auth::guard('warga')->login(
            $warga,
            $request->boolean('remember')
        );

        $request->session()->regenerate();

        return redirect()
            ->route('warga.dashboard')
            ->with(
                'success',
                'Login berhasil. Selamat datang, ' . $warga->nama . '!'
            );
    }

    public function logout(Request $request)
    {
        // Hanya logout warga
        Auth::guard('warga')->logout();

        // Jangan invalidate session karena bisa ikut menghapus
        // session login admin/pengurus di tab lain.
        $request->session()->regenerateToken();

        return redirect()
            ->route('warga.login')
            ->with('success', 'Berhasil logout.');
    }
}