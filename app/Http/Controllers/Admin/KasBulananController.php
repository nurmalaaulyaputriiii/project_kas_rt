<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KasBulanan;
use Illuminate\Http\Request;

class KasBulananController extends Controller
{
    public function index()
    {
        $kas = KasBulanan::orderBy('tahun', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.kas.index', compact('kas'));
    }

    public function create()
    {
        return view('admin.kas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bulan' => 'required|string|max:50',
            'tahun' => 'required|integer',
            'nominal' => 'required|numeric|min:0',
        ]);

        KasBulanan::create($validated);

        return redirect()
            ->route('admin.kas.index')
            ->with('success', 'Data kas berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kas = KasBulanan::findOrFail($id);

        return view('admin.kas.show', compact('kas'));
    }

    public function edit($id)
    {
        $kas = KasBulanan::findOrFail($id);

        return view('admin.kas.edit', compact('kas'));
    }

    public function update(Request $request, $id)
    {
        $kas = KasBulanan::findOrFail($id);

        $validated = $request->validate([
            'bulan' => 'required|string|max:50',
            'tahun' => 'required|integer',
            'nominal' => 'required|numeric|min:0',
        ]);

        $kas->update($validated);

        return redirect()
            ->route('admin.kas.index')
            ->with('success', 'Data kas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kas = KasBulanan::findOrFail($id);

        $kas->delete();

        return redirect()
            ->route('admin.kas.index')
            ->with('success', 'Data kas berhasil dihapus.');
    }
}