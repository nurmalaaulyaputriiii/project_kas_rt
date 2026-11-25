@extends('layout.app')

@section('title', 'Pengumuman')

@section('content')

<div class="topbar">
    <div>
        <h1 class="page-title">Pengumuman</h1>
        <div class="page-subtitle">
            Kelola pengumuman untuk warga
        </div>
    </div>

    <a href="{{ route('admin.pengumuman.create') }}"
       class="btn btn-primary-custom">
        <i class="fa-solid fa-plus"></i>
        Tambah Pengumuman
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="table-card">

    <div class="table-responsive">

        <table class="table">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($pengumuman as $item)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            <strong>{{ $item->judul }}</strong>
                        </td>

                        <td>
                            {{ Str::limit($item->isi, 80) }}
                        </td>

                        <td>
                            {{ $item->tanggal
                                ? $item->tanggal->format('d/m/Y')
                                : '-' }}
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

                            <a href="{{ route('admin.pengumuman.edit', $item->id) }}"
                               class="btn btn-warning btn-sm">

                                <i class="fa-solid fa-pen"></i>

                            </a>

                            <form action="{{ route('admin.pengumuman.destroy', $item->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm">

                                    <i class="fa-solid fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6"
                            class="text-center py-5">

                            Belum ada pengumuman.

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection