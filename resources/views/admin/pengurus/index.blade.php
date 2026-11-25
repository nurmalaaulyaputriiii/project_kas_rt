@extends('layout.app')

@section('title', 'Petugas | SIKAS')

@section('content')

<style>
    .petugas-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .petugas-title {
        font-size: 28px;
        font-weight: 700;
        color: #172033;
        margin-bottom: 5px;
    }

    .petugas-subtitle {
        color: #718096;
        font-size: 14px;
    }

    .btn-tambah {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #1677f2;
        color: white;
        text-decoration: none;
        padding: 11px 18px;
        border-radius: 9px;
        font-size: 14px;
        font-weight: 600;
        transition: .2s;
    }

    .btn-tambah:hover {
        background: #075fcf;
        color: white;
    }

    .petugas-card {
        background: white;
        border-radius: 15px;
        padding: 28px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, .06);
    }

    .card-header-petugas {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }

    .card-icon {
        width: 48px;
        height: 48px;
        background: #eff6ff;
        color: #1677f2;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .card-title-petugas {
        font-size: 20px;
        font-weight: 700;
        margin: 0;
        color: #172033;
    }

    .card-subtitle {
        font-size: 13px;
        color: #718096;
        margin-top: 3px;
    }

    .table-wrapper {
        overflow-x: auto;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
    }

    .petugas-table {
        margin: 0;
        min-width: 650px;
    }

    .petugas-table thead th {
        background: #1677f2;
        color: white;
        font-size: 13px;
        font-weight: 600;
        padding: 15px 16px;
        border: none;
        white-space: nowrap;
    }

    .petugas-table tbody td {
        padding: 16px;
        font-size: 13px;
        color: #374151;
        border-bottom: 1px solid #edf0f4;
        vertical-align: middle;
    }

    .petugas-table tbody tr:last-child td {
        border-bottom: none;
    }

    .petugas-table tbody tr:hover {
        background: #f8fbff;
    }

    .number-cell {
        width: 60px;
        color: #718096 !important;
        font-weight: 600;
    }

    .nama-cell {
        font-weight: 600;
        color: #172033 !important;
    }

    .email-cell {
        color: #4b5563;
    }

    .aksi {
        display: flex;
        gap: 7px;
    }

    .btn-aksi {
        width: 34px;
        height: 34px;
        border: none;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: .2s;
    }

    .btn-edit {
        background: #fff7ed;
        color: #ea580c;
    }

    .btn-edit:hover {
        background: #ffedd5;
        color: #c2410c;
    }

    .btn-hapus {
        background: #fef2f2;
        color: #dc2626;
    }

    .btn-hapus:hover {
        background: #fee2e2;
        color: #b91c1c;
    }

    .empty-state {
        padding: 60px 20px !important;
        text-align: center;
    }

    .empty-icon {
        width: 70px;
        height: 70px;
        background: #eff6ff;
        color: #1677f2;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        font-size: 27px;
    }

    .empty-title {
        font-size: 17px;
        font-weight: 600;
        color: #172033;
        margin-bottom: 5px;
    }

    .empty-text {
        color: #718096;
        font-size: 13px;
        margin: 0;
    }

    .alert {
        border-radius: 10px;
        border: none;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .petugas-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 15px;
        }

        .petugas-title {
            font-size: 23px;
        }

        .petugas-card {
            padding: 18px;
        }
    }
</style>

<div>

    {{-- HEADER --}}
    <div class="petugas-header">

        <div>
            <h1 class="petugas-title">
                Petugas
            </h1>

            <div class="petugas-subtitle">
                Kelola data petugas SIKAS
            </div>
        </div>

        <a
            href="{{ route('admin.pengurus.create') }}"
            class="btn-tambah"
        >
            <i class="fa-solid fa-plus"></i>
            Tambah Petugas
        </a>

    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- CARD --}}
    <div class="petugas-card">

        <div class="card-header-petugas">

            <div class="card-icon">
                <i class="fa-solid fa-user-tie"></i>
            </div>

            <div>
                <h2 class="card-title-petugas">
                    Daftar Petugas
                </h2>

                <div class="card-subtitle">
                    Daftar petugas yang dapat mengelola sistem SIKAS
                </div>
            </div>

        </div>

        <div class="table-wrapper">

            <table class="table petugas-table">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Petugas</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($pengurus as $item)

                        <tr>

                            <td class="number-cell">
                                {{ $loop->iteration }}
                            </td>

                            <td class="nama-cell">
                                {{ $item->nama }}
                            </td>

                            <td class="email-cell">
                                {{ $item->email }}
                            </td>

                            <td>

                                <div class="aksi">

                                    <a
                                        href="{{ route('admin.pengurus.edit', $item) }}"
                                        class="btn-aksi btn-edit"
                                        title="Edit"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <form
                                        action="{{ route('admin.pengurus.destroy', $item) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus petugas ini?')"
                                        class="d-inline"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn-aksi btn-hapus"
                                            title="Hapus"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="empty-state">

                                <div class="empty-icon">
                                    <i class="fa-solid fa-user-tie"></i>
                                </div>

                                <div class="empty-title">
                                    Belum Ada Petugas
                                </div>

                                <p class="empty-text">
                                    Belum ada petugas yang terdaftar.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection