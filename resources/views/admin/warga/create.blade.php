@extends('layout.app')

@section('title', 'Tambah Data Warga | SI-KAS RT')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h2>Tambah Data Warga</h2>
        <p class="text-muted">
            Tambahkan data Kepala Keluarga
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('admin.warga.store') }}"
                method="POST"
            >
                @csrf

                {{-- NOMOR KK --}}
                <div class="mb-3">
                    <label class="form-label">
                        Nomor KK
                    </label>

                    <input
                        type="text"
                        name="no_kk"
                        class="form-control"
                        maxlength="16"
                        value="{{ old('no_kk') }}"
                        placeholder="Masukkan Nomor KK"
                        required
                    >

                    <small class="text-muted">
                        Nomor KK digunakan warga untuk login dan registrasi.
                    </small>
                </div>

                {{-- NAMA --}}
                <div class="mb-3">
                    <label class="form-label">
                        Nama Kepala Keluarga
                    </label>

                    <input
                        type="text"
                        name="nama"
                        class="form-control"
                        value="{{ old('nama') }}"
                        placeholder="Masukkan nama kepala keluarga"
                        required
                    >
                </div>

                {{-- ALAMAT --}}
                <div class="mb-3">
                    <label class="form-label">
                        Alamat
                    </label>

                    <textarea
                        name="alamat"
                        class="form-control"
                        rows="3"
                        placeholder="Masukkan alamat"
                        required
                    >{{ old('alamat') }}</textarea>
                </div>

                {{-- NO HP --}}
                <div class="mb-3">
                    <label class="form-label">
                        No. HP
                    </label>

                    <input
                        type="text"
                        name="no_hp"
                        class="form-control"
                        value="{{ old('no_hp') }}"
                        placeholder="Masukkan nomor HP"
                        required
                    >
                </div>

                {{-- TANGGAL DAFTAR --}}
                <div class="mb-3">
                    <label for="tanggal_daftar" class="form-label">
                        Tanggal Didaftarkan
                    </label>

                    <input
                        type="date"
                        name="tanggal_daftar"
                        id="tanggal_daftar"
                        class="form-control"
                        value="{{ old('tanggal_daftar', now()->format('Y-m-d')) }}"
                        required
                    >

                    <small class="text-muted">
                        Tanggal ini menentukan mulai bulan warga wajib membayar iuran.
                        Iuran sebelum bulan dan tahun ini tidak akan ditagihkan.
                    </small>
                </div>

                {{-- STATUS --}}
                <div class="mb-3">
                    <label class="form-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select"
                        required
                    >
                        <option
                            value="Aktif"
                            {{ old('status', 'Aktif') == 'Aktif' ? 'selected' : '' }}
                        >
                            Aktif
                        </option>

                        <option
                            value="Tidak Aktif"
                            {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}
                        >
                            Tidak Aktif
                        </option>
                    </select>
                </div>

                {{-- TOMBOL --}}
                <div class="d-flex gap-2">
                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="fa-solid fa-save me-1"></i>
                        Simpan
                    </button>

                    <a
                        href="{{ route('admin.warga.index') }}"
                        class="btn btn-secondary"
                    >
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection