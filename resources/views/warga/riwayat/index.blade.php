@extends('layout.warga')

@section('title', 'Riwayat Pembayaran | SIKAS')

@section('content')

<style>
    /* =========================
       HALAMAN
    ========================= */

    .history-page {
        width: 100%;
        max-width: none;
        margin: 0;
    }

    /* =========================
       HEADER
    ========================= */

    .history-header {
        width: 100%;
        background: linear-gradient(135deg, #1976ed, #0752b7);
        border-radius: 18px;
        padding: 28px 30px;
        color: #fff;
        margin-bottom: 24px;
        box-shadow: 0 8px 25px rgba(25, 118, 237, .15);
    }

    .history-header-content {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .history-header-icon {
        width: 58px;
        height: 58px;
        border-radius: 15px;
        background: rgba(255,255,255,.16);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
        flex-shrink: 0;
    }

    .history-header h1 {
        font-size: 25px;
        font-weight: 700;
        margin: 0 0 5px;
    }

    .history-header p {
        margin: 0;
        font-size: 14px;
        opacity: .88;
    }

    /* =========================
       ALERT
    ========================= */

    .history-alert {
        width: 100%;
        border-radius: 12px;
        padding: 14px 17px;
        margin-bottom: 20px;
        font-size: 13px;
        border: none;
    }

    /* =========================
       CARD
    ========================= */

    .history-card {
        width: 100%;
        max-width: none;
        background: #fff;
        border: 1px solid #e8edf3;
        border-radius: 16px;
        padding: 28px;
        margin-bottom: 22px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, .04);
    }

    /* =========================
       SECTION HEADER
    ========================= */

    .section-header {
        display: flex;
        align-items: center;
        gap: 13px;
        margin-bottom: 20px;
    }

    .section-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .section-title {
        color: #172033;
        font-size: 18px;
        font-weight: 700;
        margin: 0;
    }

    .section-subtitle {
        color: #8992a3;
        font-size: 13px;
        margin-top: 3px;
    }

    /* =========================
       DATA WARGA
    ========================= */

    .warga-card {
        display: flex;
        align-items: center;
        gap: 17px;
    }

    .warga-icon {
        width: 55px;
        height: 55px;
        border-radius: 14px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .warga-label {
        color: #8992a3;
        font-size: 12px;
        margin-bottom: 4px;
    }

    .warga-name {
        color: #172033;
        font-size: 17px;
        font-weight: 700;
        margin-bottom: 3px;
    }

    .warga-kk {
        color: #8992a3;
        font-size: 12px;
    }

    /* =========================
       TABLE
    ========================= */

    .history-table-wrapper {
        width: 100%;
        border: 1px solid #e8edf3;
        border-radius: 12px;
        overflow-x: auto;
    }

    .history-table {
        width: 100%;
        min-width: 950px;
        margin: 0;
        border-collapse: collapse;
    }

    .history-table thead th {
        background: #f8fafc;
        color: #667085;
        font-size: 12px;
        font-weight: 600;
        padding: 14px 15px;
        border-bottom: 1px solid #e8edf3;
        white-space: nowrap;
    }

    .history-table tbody td {
        padding: 15px;
        color: #344054;
        font-size: 13px;
        border-bottom: 1px solid #edf1f5;
        vertical-align: middle;
    }

    .history-table tbody tr:last-child td {
        border-bottom: none;
    }

    .history-table tbody tr {
        transition: .2s ease;
    }

    .history-table tbody tr:hover {
        background: #f8fbff;
    }

    .number-cell {
        color: #8992a3;
        font-weight: 500;
        width: 45px;
    }

    .payment-name {
        color: #172033;
        font-weight: 600;
    }

    .payment-date {
        color: #667085;
        white-space: nowrap;
    }

    .payment-amount {
        color: #1976ed;
        font-weight: 700;
        white-space: nowrap;
    }

    /* =========================
       BADGE
    ========================= */

    .custom-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-lunas {
        background: #ecfdf3;
        color: #15803d;
    }

    .badge-cicilan {
        background: #fff7ed;
        color: #c2410c;
    }

    .badge-verifikasi {
        background: #fff7ed;
        color: #b45309;
    }

    .badge-konfirmasi {
        background: #eff6ff;
        color: #2563eb;
    }

    .badge-secondary {
        background: #f1f5f9;
        color: #64748b;
    }

    /* =========================
       METODE PEMBAYARAN
    ========================= */

    .payment-method {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #475467;
        white-space: nowrap;
    }

    .payment-method i {
        color: #1976ed;
    }

    .payment-method.cash i {
        color: #16a34a;
    }

    /* =========================
       KETERANGAN
    ========================= */

    .description {
        max-width: 180px;
        color: #667085;
    }

    /* =========================
       EMPTY
    ========================= */

    .empty-history {
        text-align: center;
        padding: 55px 20px;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 31px;
    }

    .empty-history h4 {
        color: #172033;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .empty-history p {
        color: #8992a3;
        font-size: 13px;
        margin-bottom: 22px;
    }

    .btn-payment {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 11px 18px;
        border-radius: 9px;
        background: linear-gradient(135deg, #1976ed, #0752b7);
        color: #fff;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: .2s ease;
    }

    .btn-payment:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(25,118,237,.2);
    }

    /* =========================
       RESPONSIVE
    ========================= */

    @media (max-width: 700px) {

        .history-header {
            padding: 22px;
        }

        .history-header h1 {
            font-size: 21px;
        }

        .history-header-content {
            align-items: flex-start;
        }

        .history-header-icon {
            width: 48px;
            height: 48px;
            font-size: 20px;
        }

        .history-card {
            padding: 18px;
        }

        .warga-icon {
            width: 48px;
            height: 48px;
            font-size: 19px;
        }

        .warga-name {
            font-size: 15px;
        }
    }
</style>


<div class="container-fluid py-4">

    <div class="history-page">

        {{-- HEADER --}}
        <div class="history-header">

            <div class="history-header-content">

                <div class="history-header-icon">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>

                <div>

                    <h1>
                        Riwayat Pembayaran
                    </h1>

                    <p>
                        Riwayat pembayaran iuran kas warga yang telah dilakukan
                    </p>

                </div>

            </div>

        </div>


        {{-- PESAN BERHASIL --}}
        @if(session('success'))

            <div class="alert alert-success history-alert">

                <i class="fa-solid fa-circle-check me-2"></i>

                {{ session('success') }}

            </div>

        @endif


        {{-- PESAN ERROR --}}
        @if($errors->any())

            <div class="alert alert-danger history-alert">

                <i class="fa-solid fa-circle-exclamation me-2"></i>

                {{ $errors->first() }}

            </div>

        @endif


        {{-- DATA WARGA --}}
        <div class="history-card">

            <div class="warga-card">

                <div class="warga-icon">

                    <i class="fa-solid fa-user"></i>

                </div>

                <div>

                    <div class="warga-label">
                        Kepala Keluarga
                    </div>

                    <div class="warga-name">
                        {{ $warga->nama }}
                    </div>

                    <div class="warga-kk">

                        <i class="fa-solid fa-id-card me-1"></i>

                        No. KK: {{ $warga->no_kk }}

                    </div>

                </div>

            </div>

        </div>


        {{-- RIWAYAT PEMBAYARAN --}}
        <div class="history-card">

            <div class="section-header">

                <div class="section-icon">

                    <i class="fa-solid fa-receipt"></i>

                </div>

                <div>

                    <h2 class="section-title">
                        Riwayat Pembayaran
                    </h2>

                    <div class="section-subtitle">
                        Daftar pembayaran iuran yang telah kamu lakukan
                    </div>

                </div>

            </div>


            @if($pembayaran->count() > 0)

                <div class="history-table-wrapper">

                    <table class="history-table">

                        <thead>

                            <tr>

                                <th>No</th>

                                <th>Iuran</th>

                                <th>Tanggal Bayar</th>

                                <th>Nominal</th>

                                <th>Jenis</th>

                                <th>Metode</th>

                                <th>Status</th>

                                <th>Keterangan</th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($pembayaran as $item)

                                <tr>

                                    {{-- NO --}}
                                    <td class="number-cell">

                                        {{ $loop->iteration }}

                                    </td>


                                    {{-- IURAN --}}
                                    <td>

                                        <div class="payment-name">

                                            @php

                                                $kas = \App\Models\KasBulanan::find(
                                                    $item->kas_bulanan_id
                                                );

                                            @endphp

                                            @if($kas)

                                                {{ $kas->bulan }} {{ $kas->tahun }}

                                            @else

                                                -

                                            @endif

                                        </div>

                                    </td>


                                    {{-- TANGGAL --}}
                                    <td class="payment-date">

                                        @if($item->tanggal_bayar)

                                            <i class="fa-regular fa-calendar me-1"></i>

                                            {{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d/m/Y H:i') }}

                                        @else

                                            -

                                        @endif

                                    </td>


                                    {{-- NOMINAL --}}
                                    <td>

                                        <span class="payment-amount">

                                            Rp {{ number_format($item->jumlah, 0, ',', '.') }}

                                        </span>

                                    </td>


                                    {{-- JENIS --}}
                                    <td>

                                        @if(
                                            strtolower($item->jenis_pembayaran ?? '') === 'lunas'
                                        )

                                            <span class="custom-badge badge-lunas">

                                                <i class="fa-solid fa-check"></i>

                                                Lunas

                                            </span>

                                        @elseif(
                                            strtolower($item->jenis_pembayaran ?? '') === 'cicilan'
                                        )

                                            <span class="custom-badge badge-cicilan">

                                                <i class="fa-solid fa-clock"></i>

                                                Cicilan

                                            </span>

                                        @else

                                            <span class="text-muted">
                                                -
                                            </span>

                                        @endif

                                    </td>


                                    {{-- METODE --}}
                                    <td>

                                        @if(
                                            strtolower($item->metode_pembayaran ?? '') === 'transfer'
                                        )

                                            <span class="payment-method">

                                                <i class="fa-solid fa-building-columns"></i>

                                                Transfer

                                            </span>

                                        @elseif(
                                            strtolower($item->metode_pembayaran ?? '') === 'tunai'
                                        )

                                            <span class="payment-method cash">

                                                <i class="fa-solid fa-money-bill-wave"></i>

                                                Tunai

                                            </span>

                                        @else

                                            -

                                        @endif

                                    </td>


                                    {{-- STATUS --}}
                                    <td>

                                        @if($item->status === 'Lunas')

                                            <span class="custom-badge badge-lunas">

                                                <i class="fa-solid fa-circle-check"></i>

                                                Lunas

                                            </span>

                                        @elseif($item->status === 'Cicilan')

                                            <span class="custom-badge badge-cicilan">

                                                <i class="fa-solid fa-clock"></i>

                                                Cicilan

                                            </span>

                                        @elseif($item->status === 'Menunggu Verifikasi')

                                            <span class="custom-badge badge-verifikasi">

                                                <i class="fa-solid fa-hourglass-half"></i>

                                                Menunggu Verifikasi

                                            </span>

                                        @elseif($item->status === 'Menunggu Konfirmasi')

                                            <span class="custom-badge badge-konfirmasi">

                                                <i class="fa-solid fa-hourglass-half"></i>

                                                Menunggu Konfirmasi

                                            </span>

                                        @else

                                            <span class="custom-badge badge-secondary">

                                                {{ $item->status ?? '-' }}

                                            </span>

                                        @endif

                                    </td>


                                    {{-- KETERANGAN --}}
                                    <td>

                                        @if($item->keterangan)

                                            <span
                                                class="description"
                                                title="{{ $item->keterangan }}"
                                            >

                                                {{ \Illuminate\Support\Str::limit($item->keterangan, 25) }}

                                            </span>

                                        @else

                                            <span class="text-muted">
                                                -
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


            @else

                {{-- BELUM ADA RIWAYAT --}}
                <div class="empty-history">

                    <div class="empty-icon">

                        <i class="fa-solid fa-clock-rotate-left"></i>

                    </div>

                    <h4>
                        Belum Ada Riwayat Pembayaran
                    </h4>

                    <p>
                        Kamu belum melakukan pembayaran iuran kas warga.
                    </p>

                    <a
                        href="{{ route('warga.pembayaran') }}"
                        class="btn-payment"
                    >

                        <i class="fa-solid fa-money-bill-wave me-2"></i>

                        Bayar Iuran

                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection