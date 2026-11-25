@extends('layout.app')

@section('title', 'Tambah Pengeluaran')

@section('content')

<div class="topbar">

    <div>
        <h1 class="page-title">
            Tambah Pengeluaran
        </h1>

        <div class="page-subtitle">
            Masukkan transaksi pengeluaran kas
        </div>
    </div>

</div>

<div class="form-card">

    <form action="{{ route('admin.pengeluaran.store') }}"
          method="POST">

        @csrf

        <div class="mb-3">

            <label class="form-label">
                Tanggal
            </label>

            <input type="date"
                   name="tanggal"
                   class="form-control"
                   value="{{ old('tanggal', date('Y-m-d')) }}"
                   required>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Keperluan
            </label>

            <input type="text"
                   name="keperluan"
                   class="form-control"
                   placeholder="Contoh: Beli lampu jalan"
                   required>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Jumlah
            </label>

            <input type="number"
                   name="jumlah"
                   class="form-control"
                   placeholder="150000"
                   min="0"
                   required>

        </div>

        <div class="mb-4">

            <label class="form-label">
                Keterangan
            </label>

            <textarea name="keterangan"
                      class="form-control"
                      rows="3"></textarea>

        </div>

        <a href="{{ route('admin.pengeluaran.index') }}"
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