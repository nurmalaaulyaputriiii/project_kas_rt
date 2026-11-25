<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Warga;

class PengurusWargaController extends Controller
{
    public function index()
    {
        $warga = Warga::latest()->get();

        return view('pengurus.warga.index', compact('warga'));
    }

    public function show(Warga $warga)
    {
        return view('pengurus.warga.show', compact('warga'));
    }
}