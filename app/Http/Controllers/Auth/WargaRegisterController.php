<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WargaRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.warga-register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'no_kk' => 'required|string|size:16',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'no_kk.required' => 'Nomor KK wajib diisi.',
            'no_kk.size' => 'Nomor KK harus 16 digit.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);

        $warga = Warga::where('no_kk', $validated['no_kk'])
            ->where('status', 'Aktif')
            ->first();

        if (!$warga) {
            return back()
                ->withErrors([
                    'no_kk' => 'Nomor KK belum didaftarkan oleh RT/Admin.',
                ])
                ->withInput();
        }

        if ($warga->password) {
            return back()
                ->withErrors([
                    'no_kk' => 'Nomor KK ini sudah memiliki akun. Silakan login.',
                ])
                ->withInput();
        }

        $warga->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('warga.login')
            ->with('success', 'Password berhasil dibuat. Silakan login.');
    }
}