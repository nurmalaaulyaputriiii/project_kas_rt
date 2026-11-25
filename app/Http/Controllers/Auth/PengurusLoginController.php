<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengurusLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.pengurus-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::guard('pengurus')->attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()
                ->route('pengurus.dashboard')
                ->with('success', 'Login berhasil. Selamat datang!');
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Hanya logout pengurus
        Auth::guard('pengurus')->logout();

        // Jangan invalidate session
        $request->session()->regenerateToken();

        return redirect()
            ->route('pengurus.login')
            ->with('success', 'Berhasil logout.');
    }
}