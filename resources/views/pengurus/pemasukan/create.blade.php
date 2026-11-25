@extends('layout.pengurus')

@section('title', 'Tambah Pemasukan')

@section('content')

<div class="topbar">

    <div>
        <h1 class="page-title">
            Tambah Pemasukan
        </h1>

        <div class="page-subtitle">
            Masukkan pemasukan kas RT
        </div>
    </div>

</div>

<div class="form-card">

<form action="{{ route('pengurus.pemasukan.store') }}"
      method="POST">

    @csrf

    <div class="mb-3">

        <label class="form-label">
            Tanggal
        </label>

        <input type="date"
               name="tanggal"
               class="form-control"
               value="{{ date('Y-m-d') }}"
               required>

    </div>

    <div class="mb-3">

        <label class="form-label">
            Sumber
        </label>

        <input type="text"
               name="sumber"
               class="form-control"
               placeholder="Contoh: Iuran warga"
               required>

    </div>

    <div class="mb-3">

        <label class="form-label">
            Jumlah
        </label>

        <input type="number"
               name="jumlah"
               class="form-control"
               min="0"
               required>

    </div>

    <div class="mb-4">

        <label class="form-label">
            Keterangan
        </label>

        <textarea name="keterangan"
                  class="form-control"></textarea>

    </div>

    <a href="{{ route('pengurus.pemasukan.index') }}"
       class="btn btn-secondary">
        Kembali
    </a>

    <button class="btn btn-primary-custom">
        <i class="fa-solid fa-save"></i>
        Simpan
    </button>

</form>

</div>

@endsection