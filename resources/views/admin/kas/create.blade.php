@extends('layout.app')

@section('title', 'Tambah Kas Bulanan')

@section('content')

<div class="topbar">

    <div>
        <h1 class="page-title">
            Tambah Kas Bulanan
        </h1>

        <div class="page-subtitle">
            Tambahkan data kas bulanan
        </div>
    </div>

</div>

<div class="form-card">

    <form action="{{ route('admin.kas.store') }}" method="POST">

        @csrf

        <div class="mb-3">

            <label class="form-label">
                Bulan
            </label>

            <select
                name="bulan"
                class="form-select"
                required
            >

                <option value="">
                    -- Pilih Bulan --
                </option>

                <option value="Januari">Januari</option>
                <option value="Februari">Februari</option>
                <option value="Maret">Maret</option>
                <option value="April">April</option>
                <option value="Mei">Mei</option>
                <option value="Juni">Juni</option>
                <option value="Juli">Juli</option>
                <option value="Agustus">Agustus</option>
                <option value="September">September</option>
                <option value="Oktober">Oktober</option>
                <option value="November">November</option>
                <option value="Desember">Desember</option>

            </select>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Tahun
            </label>

            <input
                type="number"
                name="tahun"
                class="form-control"
                value="{{ date('Y') }}"
                required
            >

        </div>

        <div class="mb-4">

            <label class="form-label">
                Nominal Kas
            </label>

            <input
                type="number"
                name="nominal"
                class="form-control"
                placeholder="Contoh: 50000"
                min="0"
                required
            >

        </div>

        <a
            href="{{ route('admin.kas.index') }}"
            class="btn btn-secondary"
        >
            Kembali
        </a>

        <button
            type="submit"
            class="btn btn-primary-custom"
        >
            <i class="fa-solid fa-save"></i>
            Simpan
        </button>

    </form>

</div>

@endsection