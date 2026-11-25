<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengurusPengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::orderBy('id', 'desc')->get();

        return view('pengurus.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('pengurus.pengumuman.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal' => 'required|date',
            'status' => 'required|string',
        ]);

        Pengumuman::create($validated);

        return redirect()
            ->route('pengurus.pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        return view('pengurus.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal' => 'required|date',
            'status' => 'required|string',
        ]);

        $pengumuman->update($validated);

        return redirect()
            ->route('pengurus.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        $pengumuman->delete();

        return redirect()
            ->route('pengurus.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}