@extends('layout.app')

@section('title', 'Tambah Pengumuman')

@section('content')

<div class="topbar">
    <div>
        <h1 class="page-title">Tambah Pengumuman</h1>
        <div class="page-subtitle">Buat pengumuman baru untuk warga</div>
    </div>
</div>

<div class="form-card">

    <form action="{{ route('admin.pengumuman.store') }}" method="POST">

        @csrf

        <div class="mb-3">
            <label class="form-label">Judul Pengumuman</label>

            <input type="text"
                   name="judul"
                   class="form-control"
                   value="{{ old('judul') }}"
                   placeholder="Masukkan judul"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Isi Pengumuman</label>

            <textarea name="isi"
                      class="form-control"
                      rows="6"
                      placeholder="Tulis isi pengumuman..."
                      required>{{ old('isi') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal</label>

            <input type="date"
                   name="tanggal"
                   class="form-control"
                   value="{{ old('tanggal', date('Y-m-d')) }}"
                   required>
        </div>

        <div class="mb-4">
            <label class="form-label">Status</label>

            <select name="status" class="form-select" required>
                <option value="Aktif">Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
            </select>
        </div>

        <a href="{{ route('admin.pengumuman.index') }}"
           class="btn btn-secondary">
            Kembali
        </a>

        <button type="submit"
                class="btn btn-primary-custom">
            <i class="fa-solid fa-save"></i>
            Simpan Pengumuman
        </button>

    </form>

</div>

@endsection