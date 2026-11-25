@extends('layout.app')

@section('title', 'Edit Pembayaran Iuran')

@section('content')

<div class="topbar">
    <div>
        <h1 class="page-title">Edit Pembayaran Iuran</h1>
        <div class="page-subtitle">Perbarui data pembayaran warga</div>
    </div>
</div>

<div class="form-card">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pembayaran.update', $pembayaran->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Warga</label>

            <select name="warga_id" class="form-select" required>

                @foreach ($warga as $item)
                    <option value="{{ $item->id }}"
                        {{ $pembayaran->warga_id == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach

            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Kas Bulanan</label>

            <select name="kas_bulanan_id"
                    class="form-select"
                    required>

                @foreach ($kas as $item)
                    <option value="{{ $item->id }}"
                        {{ $pembayaran->kas_bulanan_id == $item->id ? 'selected' : '' }}>

                        {{ $item->bulan }} {{ $item->tahun }}
                        - Rp {{ number_format($item->nominal, 0, ',', '.') }}

                    </option>
                @endforeach

            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Bayar</label>

            <input type="date"
                   name="tanggal_bayar"
                   class="form-control"
                   value="{{ $pembayaran->tanggal_bayar
                       ? $pembayaran->tanggal_bayar->format('Y-m-d')
                       : '' }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jumlah Pembayaran</label>

            <input type="number"
                   name="jumlah"
                   class="form-control"
                   value="{{ $pembayaran->jumlah }}"
                   min="0"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>

            <select name="status"
                    class="form-select"
                    required>

                <option value="Lunas"
                    {{ $pembayaran->status == 'Lunas' ? 'selected' : '' }}>
                    Lunas
                </option>

                <option value="Belum Lunas"
                    {{ $pembayaran->status == 'Belum Lunas' ? 'selected' : '' }}>
                    Belum Lunas
                </option>

            </select>
        </div>

        <div class="mb-4">
            <label class="form-label">Keterangan</label>

            <textarea name="keterangan"
                      class="form-control"
                      rows="3"
                      placeholder="Keterangan (opsional)">{{ $pembayaran->keterangan }}</textarea>
        </div>

        <a href="{{ route('admin.pembayaran.index') }}"
           class="btn btn-secondary">
            Kembali
        </a>

        <button type="submit"
                class="btn btn-primary-custom">
            <i class="fa-solid fa-save"></i>
            Update Pembayaran
        </button>

    </form>

</div>

@endsection