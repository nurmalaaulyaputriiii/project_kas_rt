@extends('layout.pengurus')

@section('title', 'Data Warga | SIKAS')

@section('content')

<style>
    .warga-page {
        max-width: 100%;
    }

    .warga-header {
        margin-bottom: 25px;
    }

    .warga-title {
        font-size: 28px;
        font-weight: 700;
        color: #172033;
        margin-bottom: 5px;
    }

    .warga-subtitle {
        color: #718096;
        font-size: 14px;
    }

    .warga-info {
        background: linear-gradient(135deg, #1677f2, #0752b7);
        color: white;
        border-radius: 15px;
        padding: 22px 25px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 18px;
        box-shadow: 0 5px 15px rgba(22, 119, 242, .15);
    }

    .warga-info-icon {
        width: 55px;
        height: 55px;
        border-radius: 13px;
        background: rgba(255,255,255,.18);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
        flex-shrink: 0;
    }

    .warga-info-title {
        font-size: 17px;
        font-weight: 700;
        margin-bottom: 3px;
    }

    .warga-info-text {
        font-size: 13px;
        opacity: .9;
    }

    .warga-card {
        background: white;
        border-radius: 15px;
        padding: 28px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, .06);
    }

    .warga-card-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }

    .warga-card-icon {
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

    .warga-card-title {
        font-size: 20px;
        font-weight: 700;
        margin: 0;
        color: #172033;
    }

    .warga-card-subtitle {
        font-size: 13px;
        color: #718096;
        margin-top: 3px;
    }

    .table-wrapper {
        overflow-x: auto;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
    }

    .warga-table {
        margin: 0;
        min-width: 800px;
    }

    .warga-table thead th {
        background: #1677f2;
        color: white;
        font-size: 13px;
        font-weight: 600;
        padding: 15px 16px;
        border: none;
        white-space: nowrap;
    }

    .warga-table tbody td {
        padding: 16px;
        font-size: 13px;
        color: #374151;
        border-bottom: 1px solid #edf0f4;
        vertical-align: middle;
    }

    .warga-table tbody tr:last-child td {
        border-bottom: none;
    }

    .warga-table tbody tr {
        transition: .2s;
    }

    .warga-table tbody tr:hover {
        background: #f8fbff;
    }

    .number-cell {
        width: 55px;
        color: #718096 !important;
        font-weight: 600;
    }

    .kk-cell {
        color: #1677f2 !important;
        font-weight: 700;
        white-space: nowrap;
    }

    .nama-cell {
        font-weight: 600;
        color: #172033 !important;
        white-space: nowrap;
    }

    .alamat-cell {
        min-width: 220px;
        max-width: 350px;
    }

    .phone-cell {
        white-space: nowrap;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-aktif {
        background: #ecfdf5;
        color: #15803d;
    }

    .status-tidak-aktif {
        background: #f3f4f6;
        color: #6b7280;
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
        .warga-title {
            font-size: 23px;
        }

        .warga-info {
            padding: 18px;
        }

        .warga-card {
            padding: 18px;
        }

        .warga-card-title {
            font-size: 18px;
        }
    }
</style>

<div class="warga-page">

    {{-- HEADER --}}
    <div class="warga-header">
        <div>
            <h1 class="warga-title">
                Data Warga
            </h1>

            <div class="warga-subtitle">
                Lihat data kepala keluarga
            </div>
        </div>
    </div>

    {{-- INFO --}}
    <div class="warga-info">
        <div class="warga-info-icon">
            <i class="fa-solid fa-users"></i>
        </div>

        <div>
            <div class="warga-info-title">
                Data Kepala Keluarga
            </div>

            <div class="warga-info-text">
                Daftar kepala keluarga yang terdaftar dalam sistem SIKAS.
            </div>
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- CARD DATA --}}
    <div class="warga-card">

        <div class="warga-card-header">
            <div class="warga-card-icon">
                <i class="fa-solid fa-user-group"></i>
            </div>

            <div>
                <h2 class="warga-card-title">
                    Daftar Kepala Keluarga
                </h2>

                <div class="warga-card-subtitle">
                    Data warga yang terdaftar sebagai kepala keluarga
                </div>
            </div>
        </div>

        <div class="table-wrapper">

            <table class="table warga-table">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. KK</th>
                        <th>Nama Kepala Keluarga</th>
                        <th>Alamat</th>
                        <th>No. HP</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($warga as $item)

                        <tr>

                            <td class="number-cell">
                                {{ $loop->iteration }}
                            </td>

                            <td class="kk-cell">
                                {{ $item->no_kk }}
                            </td>

                            <td class="nama-cell">
                                {{ $item->nama }}
                            </td>

                            <td class="alamat-cell">
                                {{ $item->alamat }}
                            </td>

                            <td class="phone-cell">
                                {{ $item->no_hp }}
                            </td>

                            <td>
                                @if($item->status == 'Aktif')

                                    <span class="status-badge status-aktif">
                                        <i class="fa-solid fa-circle-check"></i>
                                        Aktif
                                    </span>

                                @else

                                    <span class="status-badge status-tidak-aktif">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                        Tidak Aktif
                                    </span>

                                @endif
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="empty-state">

                                <div class="empty-icon">
                                    <i class="fa-solid fa-users-slash"></i>
                                </div>

                                <div class="empty-title">
                                    Belum Ada Data Warga
                                </div>

                                <p class="empty-text">
                                    Belum ada data kepala keluarga yang terdaftar.
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