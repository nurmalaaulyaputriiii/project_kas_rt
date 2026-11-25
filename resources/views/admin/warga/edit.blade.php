@extends('layout.app')

@section('title', 'Edit Data Warga | SI-KAS RT')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h2>Edit Data Warga</h2>
        <p class="text-muted">
            Edit data Kepala Keluarga
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
                action="{{ route('admin.warga.update', $warga->id) }}"
                method="POST"
            >
                @csrf
                @method('PUT')

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
                        value="{{ old('no_kk', $warga->no_kk) }}"
                        required
                    >
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
                        value="{{ old('nama', $warga->nama) }}"
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
                        required
                    >{{ old('alamat', $warga->alamat) }}</textarea>
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
                        value="{{ old('no_hp', $warga->no_hp) }}"
                        required
                    >
                </div>

                {{-- TANGGAL DIDAFTARKAN --}}
                <div class="mb-3">
                    <label for="tanggal_daftar" class="form-label">
                        Tanggal Didaftarkan
                    </label>

                    <input
                        type="date"
                        name="tanggal_daftar"
                        id="tanggal_daftar"
                        class="form-control"
                        value="{{ old('tanggal_daftar', optional($warga->tanggal_daftar)->format('Y-m-d')) }}"
                        required
                    >

                    <small class="text-muted">
                        Pilih tanggal warga mulai terdaftar di RT.
                        Bulan sebelum tanggal pendaftaran tidak akan ditagihkan.
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
                            {{ old('status', $warga->status) == 'Aktif' ? 'selected' : '' }}
                        >
                            Aktif
                        </option>

                        <option
                            value="Tidak Aktif"
                            {{ old('status', $warga->status) == 'Tidak Aktif' ? 'selected' : '' }}
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
                        Update
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