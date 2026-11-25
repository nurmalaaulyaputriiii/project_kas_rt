@extends('layout.app')

@section('title', 'Tambah Petugas | SIKAS')

@section('content')

<style>
    .form-page {
        max-width: 800px;
    }

    .form-header {
        margin-bottom: 25px;
    }

    .form-title {
        font-size: 28px;
        font-weight: 700;
        color: #172033;
        margin-bottom: 5px;
    }

    .form-subtitle {
        color: #718096;
        font-size: 14px;
    }

    .form-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, .06);
    }

    .form-card-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 28px;
    }

    .form-icon {
        width: 50px;
        height: 50px;
        background: #eff6ff;
        color: #1677f2;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
    }

    .form-card-title {
        font-size: 20px;
        font-weight: 700;
        color: #172033;
        margin: 0;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-control {
        border: 1px solid #dbe1e8;
        border-radius: 9px;
        padding: 11px 13px;
        font-size: 14px;
    }

    .form-control:focus {
        border-color: #1677f2;
        box-shadow: 0 0 0 3px rgba(22, 119, 242, .1);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #edf0f4;
    }

    .btn-kembali {
        padding: 11px 18px;
        border-radius: 9px;
        text-decoration: none;
        color: #4b5563;
        background: #f3f4f6;
        font-size: 14px;
        font-weight: 600;
    }

    .btn-simpan {
        border: none;
        padding: 11px 20px;
        border-radius: 9px;
        background: #1677f2;
        color: white;
        font-size: 14px;
        font-weight: 600;
    }

    .btn-simpan:hover {
        background: #075fcf;
    }

    .error-text {
        color: #dc2626;
        font-size: 12px;
        margin-top: 5px;
    }
</style>

<div class="form-page">

    <div class="form-header">

        <h1 class="form-title">
            Tambah Petugas
        </h1>

        <div class="form-subtitle">
            Tambahkan petugas baru ke sistem SIKAS
        </div>

    </div>

    <div class="form-card">

        <div class="form-card-header">

            <div class="form-icon">
                <i class="fa-solid fa-user-plus"></i>
            </div>

            <div>
                <h2 class="form-card-title">
                    Data Petugas
                </h2>
            </div>

        </div>

        <form
            action="{{ route('admin.pengurus.store') }}"
            method="POST"
        >

            @csrf

            <div class="form-group">

                <label class="form-label">
                    Nama Petugas
                </label>

                <input
                    type="text"
                    name="nama"
                    class="form-control"
                    value="{{ old('nama') }}"
                    placeholder="Masukkan nama petugas"
                    required
                >

                @error('nama')
                    <div class="error-text">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="form-group">

                <label class="form-label">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email petugas"
                    required
                >

                @error('email')
                    <div class="error-text">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="form-group">

                <label class="form-label">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Minimal 6 karakter"
                    required
                >

                @error('password')
                    <div class="error-text">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="form-actions">

                <a
                    href="{{ route('admin.pengurus.index') }}"
                    class="btn-kembali"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn-simpan"
                >
                    <i class="fa-solid fa-floppy-disk me-2"></i>
                    Simpan Petugas
                </button>

            </div>

        </form>

    </div>

</div>

@endsection