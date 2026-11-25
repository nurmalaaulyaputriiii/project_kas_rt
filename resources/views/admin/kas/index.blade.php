@extends('layout.app')

@section('title', 'Kas Bulanan | SI-KAS RT')

@section('content')

<div class="topbar">

    <div>
        <h1 class="page-title">
            Kas Bulanan
        </h1>

        <div class="page-subtitle">
            Kelola data kas bulanan Warga
        </div>
    </div>

    <a href="{{ route('admin.kas.create') }}"
       class="btn btn-primary-custom">

        <i class="fa-solid fa-plus"></i>
        Tambah Kas Bulanan

    </a>

</div>

<div class="table-card">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="section-title mb-1">
                Daftar Kas Bulanan
            </h2>

            <div class="section-subtitle mb-0">
                Data nominal kas setiap bulan
            </div>

        </div>

    </div>

    <div class="table-responsive">

        <table class="table">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Nominal</th>
                    <th>Aksi</th>
                </tr>

            </thead>

            <tbody>

                @forelse($kas as $item)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $item->bulan }}
                        </td>

                        <td>
                            {{ $item->tahun }}
                        </td>

                        <td class="fw-bold text-success">
                            Rp {{ number_format($item->nominal, 0, ',', '.') }}
                        </td>

                        <td>

                            <a href="{{ route('admin.kas.edit', $item) }}"
                               class="btn btn-warning btn-sm">

                                <i class="fa-solid fa-pen"></i>

                            </a>

                            <form action="{{ route('admin.kas.destroy', $item) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus data kas ini?')">

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

                        <td colspan="5"
                            class="text-center py-5">

                            <i class="fa-solid fa-calendar-xmark fa-2x mb-3"></i>

                            <div>
                                Belum ada data kas bulanan.
                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection