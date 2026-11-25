<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Pemasukan;
use Illuminate\Http\Request;

class PengurusPemasukanController extends Controller
{
    public function index()
    {
        $pemasukan = Pemasukan::latest('tanggal')->get();

        return view('pengurus.pemasukan.index', compact('pemasukan'));
    }

    public function create()
    {
        return view('pengurus.pemasukan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'sumber' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        Pemasukan::create($request->all());

        return redirect()
            ->route('pengurus.pemasukan.index')
            ->with('success', 'Pemasukan berhasil ditambahkan.');
    }

    public function edit(Pemasukan $pemasukan)
    {
        return view('pengurus.pemasukan.edit', compact('pemasukan'));
    }

    public function update(Request $request, Pemasukan $pemasukan)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'sumber' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $pemasukan->update($request->all());

        return redirect()
            ->route('pengurus.pemasukan.index')
            ->with('success', 'Pemasukan berhasil diperbarui.');
    }

    public function destroy(Pemasukan $pemasukan)
    {
        $pemasukan->delete();

        return back()->with('success', 'Pemasukan berhasil dihapus.');
    }
}