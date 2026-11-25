@extends('layout.warga')

@section('title', 'Dashboard Warga | SI-KAS RT')

@section('content')

<style>
    .dashboard-warga {
        padding-bottom: 30px;
    }

    .topbar {
        margin-bottom: 28px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 14px;
    }

    .table-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 24px;
        border: 1px solid #eef0f4;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
    }

    .section-title {
        font-size: 19px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .section-subtitle {
        color: #8a93a3;
        font-size: 13px;
    }

    .info-item {
        background: #f8fafc;
        border-radius: 12px;
        padding: 13px 16px;
        margin-bottom: 12px;
    }

    .info-item:last-child {
        margin-bottom: 0;
    }

    .info-label {
        color: #7b8494;
        font-size: 12px;
        margin-bottom: 3px;
    }

    .info-value {
        color: #1f2937;
        font-size: 14px;
        font-weight: 600;
        word-break: break-word;
    }

    .payment-box {
        background: linear-gradient(135deg, #f0fdf4, #ffffff);
        border: 1px solid #dcfce7;
        border-radius: 14px;
        padding: 20px;
    }

    .payment-label {
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .payment-amount {
        font-size: 27px;
        font-weight: 800;
        color: #16a34a;
        margin-bottom: 14px;
    }

    .payment-detail {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        padding: 10px 0;
        border-top: 1px solid #e5e7eb;
        font-size: 13px;
    }

    .payment-detail span:first-child {
        color: #6b7280;
    }

    .payment-detail span:last-child {
        font-weight: 600;
        color: #374151;
    }

    .empty-payment {
        background: #fff7ed;
        border: 1px solid #fed7aa;
        border-radius: 14px;
        padding: 25px;
        text-align: center;
    }

    .empty-payment h4 {
        font-weight: 700;
        margin-bottom: 8px;
    }

    .stat-card {
        position: relative;
        overflow: hidden;
        min-height: 125px;
    }

    .stat-card::after {
        content: "";
        position: absolute;
        width: 85px;
        height: 85px;
        border-radius: 50%;
        right: -25px;
        top: -25px;
        background: rgba(255, 255, 255, 0.45);
    }

    .stat-label {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 7px;
    }

    .stat-value {
        font-size: 23px;
        font-weight: 800;
        margin: 0;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
        margin-bottom: 12px;
    }

    .icon-success {
        background: #dcfce7;
    }

    .icon-danger {
        background: #fee2e2;
    }

    .icon-primary {
        background: #dbeafe;
    }

    .btn-primary-custom {
        border-radius: 10px;
        padding: 9px 16px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
    }

    .table-card .table {
        margin-bottom: 0;
        vertical-align: middle;
    }

    .table thead th {
        background: #f8fafc;
        color: #6b7280;
        font-size: 12px;
        font-weight: 700;
        border-bottom: 1px solid #e5e7eb;
        padding: 13px 14px;
    }

    .table tbody td {
        color: #374151;
        font-size: 13px;
        padding: 14px;
        border-bottom: 1px solid #f1f5f9;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table tbody tr:hover {
        background: #fafafa;
    }

    .badge {
        border-radius: 20px;
        padding: 6px 11px;
        font-size: 11px;
        font-weight: 600;
    }

    .announcement-item {
        padding: 16px 0;
        border-bottom: 1px solid #edf0f4;
    }

    .announcement-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .announcement-title {
        font-size: 15px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 7px;
    }

    .announcement-content {
        color: #596273;
        font-size: 13px;
        line-height: 1.7;
        margin-bottom: 7px;
    }

    .announcement-date {
        font-size: 11px;
        color: #9ca3af;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 23px;
        }

        .table-card {
            padding: 18px;
            border-radius: 15px;
        }

        .payment-amount {
            font-size: 23px;
        }

        .stat-value {
            font-size: 20px;
        }

        .d-flex.justify-content-between {
            gap: 15px;
        }
    }
</style>

<div class="dashboard-warga">

    {{-- HEADER --}}
    <div class="topbar">

        <div>
            <h1 class="page-title">
                Dashboard Warga
            </h1>

            <div class="page-subtitle">
                Selamat datang, {{ $warga->nama }}
            </div>
        </div>

    </div>


    {{-- DATA KELUARGA & STATUS PEMBAYARAN --}}
    <div class="row g-4 mb-4">

        {{-- DATA KELUARGA --}}
        <div class="col-md-6">

            <div class="table-card h-100">

                <h2 class="section-title">
                    Data Keluarga
                </h2>

                <p class="section-subtitle">
                    Informasi keluarga yang terdaftar
                </p>

                <hr>

                <div class="info-item">
                    <div class="info-label">
                        Kepala Keluarga
                    </div>

                    <div class="info-value">
                        {{ $warga->nama }}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">
                        Nomor KK
                    </div>

                    <div class="info-value">
                        {{ $warga->no_kk }}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">
                        No. HP
                    </div>

                    <div class="info-value">
                        {{ $warga->no_hp ?? '-' }}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">
                        Alamat
                    </div>

                    <div class="info-value">
                        {{ $warga->alamat ?? '-' }}
                    </div>
                </div>

            </div>

        </div>


        {{-- STATUS PEMBAYARAN --}}
        <div class="col-md-6">

            <div class="table-card h-100">

                <h2 class="section-title">
                    Status Pembayaran
                </h2>

                <p class="section-subtitle">
                    Informasi pembayaran iuran terakhir
                </p>

                <hr>

                @if($pembayaranTerakhir)

                    <div class="payment-box">

                        <div class="payment-label">
                            Iuran Terakhir
                        </div>

                        <div class="payment-amount">
                            Rp {{ number_format($pembayaranTerakhir->jumlah ?? 0, 0, ',', '.') }}
                        </div>

                        <div class="payment-detail">

                            <span>
                                Status
                            </span>

                            <span>
                                @if(strtolower($pembayaranTerakhir->status ?? '') == 'lunas')

                                    <strong class="text-success">
                                        LUNAS ✓
                                    </strong>

                                @else

                                    <strong class="text-danger">
                                        {{ strtoupper($pembayaranTerakhir->status ?? 'BELUM BAYAR') }}
                                    </strong>

                                @endif
                            </span>

                        </div>

                        <div class="payment-detail">

                            <span>
                                Tanggal
                            </span>

                            <span>

                                @if($pembayaranTerakhir->tanggal_bayar)

                                    {{ \Carbon\Carbon::parse($pembayaranTerakhir->tanggal_bayar)->format('d F Y') }}

                                @else

                                    -

                                @endif

                            </span>

                        </div>

                    </div>

                @else

                    <div class="empty-payment">

                        <h4>
                            Belum Ada Pembayaran
                        </h4>

                        <p class="text-danger mb-0">
                            Belum ada riwayat pembayaran.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- INFORMASI KAS --}}
    <div class="row g-4 mb-4">

        {{-- PEMASUKAN --}}
        <div class="col-md-4">

            <div class="table-card stat-card">

                <div class="stat-icon icon-success">
                    💰
                </div>

                <p class="stat-label">
                    Total Pemasukan
                </p>

                <h3 class="stat-value text-success">
                    Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}
                </h3>

            </div>

        </div>


        {{-- PENGELUARAN --}}
        <div class="col-md-4">

            <div class="table-card stat-card">

                <div class="stat-icon icon-danger">
                    💸
                </div>

                <p class="stat-label">
                    Total Pengeluaran
                </p>

                <h3 class="stat-value text-danger">
                    Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}
                </h3>

            </div>

        </div>


        {{-- SALDO --}}
        <div class="col-md-4">

            <div class="table-card stat-card">

                <div class="stat-icon icon-primary">
                    💳
                </div>

                <p class="stat-label">
                    Saldo Kas
                </p>

                <h3 class="stat-value">
                    Rp {{ number_format($saldo ?? 0, 0, ',', '.') }}
                </h3>

            </div>

        </div>

    </div>


    {{-- RIWAYAT PEMBAYARAN --}}
    <div class="table-card mb-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2 class="section-title mb-1">
                    Riwayat Pembayaran
                </h2>

                <div class="section-subtitle mb-0">
                    Riwayat pembayaran iuran keluarga
                </div>
            </div>

            <a href="{{ route('warga.riwayat') }}"
               class="btn btn-primary-custom">
                Lihat Semua
            </a>

        </div>


        <div class="table-responsive">

            <table class="table">

                <thead>

                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nominal</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($pembayaran as $item)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>

                                @if($item->tanggal_bayar)

                                    {{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d/m/Y') }}

                                @else

                                    -

                                @endif

                            </td>

                            <td class="fw-bold text-success">
                                Rp {{ number_format($item->jumlah ?? 0, 0, ',', '.') }}
                            </td>

                            <td>

                                @if(strtolower($item->status ?? '') == 'lunas')

                                    <span class="badge bg-success">
                                        Lunas
                                    </span>

                                @else

                                    <span class="badge bg-warning text-dark">
                                        {{ $item->status ?? 'Belum Bayar' }}
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4"
                                class="text-center py-4">

                                Belum ada riwayat pembayaran.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- PENGUMUMAN RT --}}
    <div class="table-card mb-4">

        <div class="mb-4">

            <h2 class="section-title mb-1">
                Pengumuman RT
            </h2>

            <div class="section-subtitle">
                Informasi terbaru dari pengurus RT
            </div>

        </div>


        @forelse($pengumuman as $item)

            <div class="announcement-item">

                <h5 class="announcement-title">
                    📢 {{ $item->judul }}
                </h5>

                <p class="announcement-content">
                    {{ $item->isi }}
                </p>

                <small class="announcement-date">

                    @if($item->created_at)

                        {{ $item->created_at->format('d F Y') }}

                    @endif

                </small>

            </div>

        @empty

            <div class="text-center py-4">
                Belum ada pengumuman.
            </div>

        @endforelse

    </div>

</div>

@endsection