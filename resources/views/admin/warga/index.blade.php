@extends('layout.app')

@section('title', 'Data Warga | SI-KAS RT')

@section('content')

<div class="topbar">
    <div>
        <h1 class="page-title">Data Warga</h1>
        <div class="page-subtitle">
            Kelola data kepala keluarga
        </div>
    </div>

<a href="{{ route('admin.warga.create') }}" class="btn btn-primary-custom">
    <i class="fa-solid fa-plus"></i>
    Tambah Kepala Keluarga
</a>

</div>

<div class="table-card">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="section-title mb-1">
            Daftar Kepala Keluarga
        </h2>

        <div class="section-subtitle mb-0">
            Data warga yang terdaftar sebagai kepala keluarga
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="table-responsive">
    <table class="table">

        <thead>
            <tr>
                <th>No</th>
                <th>No. KK</th>
                <th>Nama Kepala Keluarga</th>
                <th>Alamat</th>
                <th>No. HP</th>
                <th>Tanggal Daftar</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

            @forelse($warga as $item)

                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <td class="fw-bold">
                        {{ $item->no_kk }}
                    </td>

                    <td>
                        {{ $item->nama }}
                    </td>

                    <td>
                        {{ $item->alamat }}
                    </td>

                    <td>
                        {{ $item->no_hp ?? '-' }}
                    </td>

                    <td>
                        @if($item->tanggal_daftar)
                            {{ $item->tanggal_daftar->format('d/m/Y') }}
                        @else
                            <span class="text-muted">
                                Belum diatur
                            </span>
                        @endif
                    </td>

                    <td>
                        @if($item->status == 'Aktif')
                            <span class="badge bg-success">
                                Aktif
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                Tidak Aktif
                            </span>
                        @endif
                    </td>

                    <td>
                        <a
                            href="{{ route('admin.warga.edit', $item) }}"
                            class="btn btn-warning btn-sm"
                        >
                            <i class="fa-solid fa-pen"></i>
                        </a>

                        <form
                            action="{{ route('admin.warga.destroy', $item) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Hapus data kepala keluarga ini?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger btn-sm"
                            >
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="8" class="text-center py-5">
                        <i class="fa-solid fa-users-slash fa-2x mb-3"></i>

                        <div>
                            Belum ada data kepala keluarga.
                        </div>
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>
</div>


</div>

@endsection
