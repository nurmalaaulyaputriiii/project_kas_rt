@extends('layout.pengurus')

@section('title', 'Pemasukan | SI-KAS RT')

@section('content')

<div class="topbar">

    <div>
        <h1 class="page-title">
            Pemasukan
        </h1>

        <div class="page-subtitle">
            Kelola pemasukan kas Warga
        </div>
    </div>

    <a href="{{ route('pengurus.pemasukan.create') }}"
       class="btn btn-primary-custom">

        <i class="fa-solid fa-plus"></i>
        Tambah Pemasukan

    </a>

</div>

<div class="table-card">

    <div class="table-responsive">

        <table class="table">

            <thead>

            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Sumber</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>

            </thead>

            <tbody>

            @forelse($pemasukan as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>
                        {{ $item->tanggal->format('d/m/Y') }}
                    </td>

                    <td>
                        {{ $item->sumber }}
                    </td>

                    <td class="fw-bold text-success">
                        Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                    </td>

                    <td>
                        {{ $item->keterangan ?? '-' }}
                    </td>

                    <td>

                        <a href="{{ route('pengurus.pemasukan.edit', $item) }}"
                           class="btn btn-warning btn-sm">

                            <i class="fa-solid fa-pen"></i>

                        </a>

                        <form action="{{ route('pengurus.pemasukan.destroy', $item) }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus pemasukan?')">

                                <i class="fa-solid fa-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6"
                        class="text-center py-5">

                        Belum ada pemasukan.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection