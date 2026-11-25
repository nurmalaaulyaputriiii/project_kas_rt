<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    public function index()
    {
        $warga = Warga::orderBy('id', 'desc')->get();

        return view('admin.warga.index', compact('warga'));
    }

    public function create()
    {
        return view('admin.warga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kk' => 'required|string|size:16|unique:warga,no_kk',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'nullable|string|max:20',
            'tanggal_daftar' => 'required|date',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        Warga::create($validated);

        return redirect()
            ->route('admin.warga.index')
            ->with('success', 'Data kepala keluarga berhasil ditambahkan.');
    }

    public function show($id)
    {
        $warga = Warga::findOrFail($id);

        return view('admin.warga.show', compact('warga'));
    }

    public function edit($id)
    {
        $warga = Warga::findOrFail($id);

        return view('admin.warga.edit', compact('warga'));
    }

    public function update(Request $request, $id)
    {
        $warga = Warga::findOrFail($id);

        $validated = $request->validate([
            'no_kk' => 'required|string|size:16|unique:warga,no_kk,' . $warga->id,
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'nullable|string|max:20',
            'tanggal_daftar' => 'required|date',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $warga->update($validated);

        return redirect()
            ->route('admin.warga.index')
            ->with('success', 'Data kepala keluarga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $warga = Warga::findOrFail($id);

        $warga->delete();

        return redirect()
            ->route('admin.warga.index')
            ->with('success', 'Data warga berhasil dihapus.');
    }
}