@extends('layout.app')

@section('title', 'Edit Petugas | SIKAS')

@section('content')

<style>
    .form-page {
        width: 100%;
        max-width: none;
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
        width: 100%;
        background: #ffffff;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, .06);
        border: 1px solid #eef1f5;
    }

    .form-card-header {
        display: flex;
        align-items: center;
        gap: 15px;
        padding-bottom: 24px;
        margin-bottom: 28px;
        border-bottom: 1px solid #edf0f4;
    }

    .form-icon {
        width: 52px;
        height: 52px;
        background: #fff7ed;
        color: #ea580c;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        flex-shrink: 0;
    }

    .form-card-title {
        font-size: 20px;
        font-weight: 700;
        color: #172033;
        margin: 0 0 4px;
    }

    .form-card-desc {
        color: #8a94a6;
        font-size: 13px;
        margin: 0;
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        min-height: 46px;
        border: 1px solid #dbe1e8;
        border-radius: 9px;
        padding: 11px 13px;
        font-size: 14px;
        color: #172033;
        background: #fff;
        transition: .2s ease;
    }

    .form-control::placeholder {
        color: #a0a8b5;
    }

    .form-control:focus {
        border-color: #1677f2;
        box-shadow: 0 0 0 3px rgba(22, 119, 242, .1);
        outline: none;
    }

    .password-info {
        color: #8a94a6;
        font-size: 12px;
        margin-top: 7px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        margin-top: 30px;
        padding-top: 22px;
        border-top: 1px solid #edf0f4;
    }

    .btn-kembali {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 10px 20px;
        border-radius: 9px;
        text-decoration: none;
        color: #4b5563;
        background: #f3f4f6;
        font-size: 14px;
        font-weight: 600;
        transition: .2s ease;
    }

    .btn-kembali:hover {
        background: #e5e7eb;
        color: #374151;
    }

    .btn-simpan {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        border: none;
        padding: 10px 22px;
        border-radius: 9px;
        background: #1677f2;
        color: white;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s ease;
    }

    .btn-simpan:hover {
        background: #075fcf;
    }

    .error-text {
        color: #dc2626;
        font-size: 12px;
        margin-top: 6px;
    }

    @media (max-width: 768px) {
        .form-card {
            padding: 22px;
        }

        .form-title {
            font-size: 24px;
        }

        .form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .btn-kembali,
        .btn-simpan {
            width: 100%;
        }
    }
</style>

<div class="form-page">

    <div class="form-header">
        <h1 class="form-title">
            Edit Petugas
        </h1>

        <div class="form-subtitle">
            Perbarui data petugas SIKAS
        </div>
    </div>

    <div class="form-card">

        <div class="form-card-header">

            <div class="form-icon">
                <i class="fa-solid fa-user-pen"></i>
            </div>

            <div>
                <h2 class="form-card-title">
                    Data Petugas
                </h2>

                <p class="form-card-desc">
                    Ubah informasi petugas yang diperlukan
                </p>
            </div>

        </div>

        <form
            action="{{ route('admin.pengurus.update', $pengurus) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="form-group">

                <label class="form-label">
                    Nama Petugas
                </label>

                <input
                    type="text"
                    name="nama"
                    class="form-control"
                    value="{{ old('nama', $pengurus->nama) }}"
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
                    value="{{ old('email', $pengurus->email) }}"
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
                    Password Baru
                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Masukkan password baru"
                >

                <div class="password-info">
                    Kosongkan jika password lama tetap digunakan.
                </div>

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
                    <i class="fa-solid fa-arrow-left me-2"></i>
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn-simpan"
                >
                    <i class="fa-solid fa-floppy-disk me-2"></i>
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection

