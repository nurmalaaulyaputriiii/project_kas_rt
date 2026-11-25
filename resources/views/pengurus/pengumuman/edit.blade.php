@extends('layout.pengurus')

@section('title', 'Edit Pengumuman')

@section('content')

<div class="topbar">
    <div>
        <h1 class="page-title">Edit Pengumuman</h1>
        <div class="page-subtitle">Perbarui pengumuman</div>
    </div>
</div>

<div class="form-card">

    <form action="{{ route('pengurus.pengumuman.update', $pengumuman->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Judul Pengumuman</label>

            <input type="text"
                   name="judul"
                   class="form-control"
                   value="{{ $pengumuman->judul }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Isi Pengumuman</label>

            <textarea name="isi"
                      class="form-control"
                      rows="6"
                      required>{{ $pengumuman->isi }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal</label>

            <input type="date"
                   name="tanggal"
                   class="form-control"
                   value="{{ $pengumuman->tanggal->format('Y-m-d') }}"
                   required>
        </div>

        <div class="mb-4">
            <label class="form-label">Status</label>

            <select name="status"
                    class="form-select"
                    required>

                <option value="Aktif"
                    {{ $pengumuman->status == 'Aktif' ? 'selected' : '' }}>
                    Aktif
                </option>

                <option value="Tidak Aktif"
                    {{ $pengumuman->status == 'Tidak Aktif' ? 'selected' : '' }}>
                    Tidak Aktif
                </option>

            </select>
        </div>

        <a href="{{ route('pengurus.pengumuman.index') }}"
           class="btn btn-secondary">
            Kembali
        </a>

        <button type="submit"
                class="btn btn-primary-custom">
            <i class="fa-solid fa-save"></i>
            Update Pengumuman
        </button>

    </form>

</div>

@endsection