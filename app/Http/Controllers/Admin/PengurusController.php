<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengurus;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    public function index()
    {
        $pengurus = Pengurus::latest()->get();

        return view('admin.pengurus.index', compact('pengurus'));
    }

    public function create()
    {
        return view('admin.pengurus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:penguruses,email',
            'password' => 'required|string|min:6',
        ], [
            'nama.required' => 'Nama petugas wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        Pengurus::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()
            ->route('admin.pengurus.index')
            ->with('success', 'Petugas berhasil ditambahkan.');
    }

    public function edit(Pengurus $penguru)
    {
        return view('admin.pengurus.edit', [
            'pengurus' => $penguru
        ]);
    }

    public function update(Request $request, Pengurus $penguru)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:penguruses,email,' . $penguru->id,
            'password' => 'nullable|string|min:6',
        ], [
            'nama.required' => 'Nama petugas wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $penguru->nama = $request->nama;
        $penguru->email = $request->email;

        if ($request->filled('password')) {
            $penguru->password = $request->password;
        }

        $penguru->save();

        return redirect()
            ->route('admin.pengurus.index')
            ->with('success', 'Data petugas berhasil diperbarui.');
    }

    public function destroy(Pengurus $penguru)
    {
        $penguru->delete();

        return redirect()
            ->route('admin.pengurus.index')
            ->with('success', 'Petugas berhasil dihapus.');
    }
}