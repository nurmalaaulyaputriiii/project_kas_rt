@extends('layout.pengurus')

@section('title', 'Pengeluaran | SI-KAS RT')

@section('content')

<div class="topbar">

    <div>
        <h1 class="page-title">
            Pengeluaran
        </h1>

        <div class="page-subtitle">
            Kelola pengeluaran kas Warga
        </div>
    </div>

    <a href="{{ route('pengurus.pengeluaran.create') }}"
       class="btn btn-primary-custom">

        <i class="fa-solid fa-plus"></i>
        Tambah Pengeluaran

    </a>

</div>

<div class="table-card">

    <div class="table-responsive">

        <table class="table">

            <thead>

            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Keperluan</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>

            </thead>

            <tbody>

            @forelse($pengeluaran as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>
                        {{ $item->tanggal->format('d/m/Y') }}
                    </td>

                    <td>
                        {{ $item->keperluan }}
                    </td>

                    <td class="fw-bold text-danger">
                        Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                    </td>

                    <td>
                        {{ $item->keterangan ?? '-' }}
                    </td>

                    <td>

                        <a href="{{ route('pengurus.pengeluaran.edit', $item) }}"
                           class="btn btn-warning btn-sm">

                            <i class="fa-solid fa-pen"></i>

                        </a>

                        <form action="{{ route('pengurus.pengeluaran.destroy', $item) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Hapus pengeluaran?')">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm">

                                <i class="fa-solid fa-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6"
                        class="text-center py-5">

                        Belum ada pengeluaran.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection