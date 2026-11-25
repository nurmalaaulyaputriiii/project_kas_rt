@extends('layout.app')

@section('title', 'Edit Pemasukan')

@section('content')

<div class="topbar">

    <div>
        <h1 class="page-title">
            Edit Pemasukan
        </h1>
    </div>

</div>

<div class="form-card">

<form action="{{ route('admin.pemasukan.update', $pemasukan) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">

        <label class="form-label">
            Tanggal
        </label>

        <input type="date"
               name="tanggal"
               class="form-control"
               value="{{ $pemasukan->tanggal->format('Y-m-d') }}"
               required>

    </div>

    <div class="mb-3">

        <label class="form-label">
            Sumber
        </label>

        <input type="text"
               name="sumber"
               class="form-control"
               value="{{ $pemasukan->sumber }}"
               required>

    </div>

    <div class="mb-3">

        <label class="form-label">
            Jumlah
        </label>

        <input type="number"
               name="jumlah"
               class="form-control"
               value="{{ $pemasukan->jumlah }}"
               required>

    </div>

    <div class="mb-4">

        <label class="form-label">
            Keterangan
        </label>

        <textarea name="keterangan"
                  class="form-control">{{ $pemasukan->keterangan }}</textarea>

    </div>

    <a href="{{ route('admin.pemasukan.index') }}"
       class="btn btn-secondary">

        Kembali

    </a>

    <button class="btn btn-primary-custom">

        Update

    </button>

</form>

</div>

@endsection