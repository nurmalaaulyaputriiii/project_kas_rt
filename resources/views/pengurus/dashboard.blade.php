@extends('layout.pengurus')

@section('title', 'Dashboard Pengurus | SI-KAS RT')

@section('content')

<style>
    .dashboard-pengurus {
        padding-bottom: 30px;
    }

    .topbar-pengurus {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .page-title-pengurus {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
    }

    .page-subtitle-pengurus {
        margin-top: 5px;
        color: #6b7280;
        font-size: 14px;
    }

    .date-box-pengurus {
        background: #eff6ff;
        color: #2563eb;
        padding: 10px 15px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
    }

    /* STAT */

    .stat-grid-pengurus {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 22px;
    }

    .stat-card-pengurus {
        background: #fff;
        border: 1px solid #eef2f7;
        border-radius: 15px;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0,0,0,.04);
    }

    .stat-label {
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .stat-number {
        margin-top: 7px;
        font-size: 22px;
        font-weight: 800;
        color: #111827;
    }

    .stat-desc {
        margin-top: 4px;
        color: #64748b;
        font-size: 12px;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 13px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 20px;
    }

    .icon-green {
        background: #dcfce7;
        color: #16a34a;
    }

    .icon-blue {
        background: #dbeafe;
        color: #2563eb;
    }

    .icon-red {
        background: #fee2e2;
        color: #dc2626;
    }

    .icon-orange {
        background: #fef3c7;
        color: #d97706;
    }

    /* GRID */

    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    .dashboard-card {
        background: #fff;
        border: 1px solid #eef2f7;
        border-radius: 15px;
        padding: 22px;
        box-shadow: 0 4px 15px rgba(0,0,0,.04);
    }

    .card-header-pengurus {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }

    .card-title {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
    }

    .card-desc {
        margin-top: 4px;
        color: #64748b;
        font-size: 13px;
    }

    .lihat-semua {
        text-decoration: none;
        color: #2563eb;
        font-size: 13px;
        font-weight: 600;
    }

    /* TABLE */

    .table-wrapper {
        overflow-x: auto;
    }

    .table-pengurus {
        width: 100%;
        border-collapse: collapse;
    }

    .table-pengurus th {
        padding: 11px 10px 12px 0;
        text-align: left;
        font-size: 11px;
        color: #94a3b8;
        text-transform: uppercase;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-pengurus td {
        padding: 13px 10px 13px 0;
        font-size: 13px;
        color: #64748b;
        border-bottom: 1px solid #f1f5f9;
    }

    .table-pengurus tr:last-child td {
        border-bottom: none;
    }

    .nama-warga {
        font-weight: 600;
        color: #1f2937 !important;
    }

    .nominal {
        font-weight: 700;
        color: #16a34a !important;
    }

    .badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-masuk {
        background: #dcfce7;
        color: #15803d;
    }

    .empty-data {
        text-align: center;
        padding: 35px 10px !important;
        color: #94a3b8 !important;
    }

    /* SIDE */

    .side-content {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .aksi-title {
        margin: 0;
        font-size: 17px;
        font-weight: 700;
        color: #1f2937;
    }

    .aksi-desc {
        margin: 6px 0 17px;
        font-size: 13px;
        line-height: 1.6;
        color: #64748b;
    }

    .btn-input {
        display: block;
        width: 100%;
        text-align: center;
        padding: 12px;
        background: #2563eb;
        color: #fff;
        text-decoration: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-input:hover {
        background: #1d4ed8;
        color: #fff;
    }

    .quick-link {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
        padding: 11px 12px;
        background: #f8fafc;
        border-radius: 9px;
        text-decoration: none;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
    }

    .quick-link:hover {
        background: #eff6ff;
        color: #2563eb;
    }

    /* RINGKASAN */

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .summary-row:last-child {
        border-bottom: none;
    }

    .summary-label {
        font-size: 13px;
        color: #64748b;
    }

    .summary-value {
        font-size: 13px;
        font-weight: 700;
        color: #1f2937;
    }

    .summary-pemasukan {
        color: #16a34a;
    }

    .summary-pengeluaran {
        color: #dc2626;
    }

    .summary-saldo {
        color: #2563eb;
        font-size: 15px;
    }

    @media (max-width: 1100px) {
        .stat-grid-pengurus {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 850px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .stat-grid-pengurus {
            grid-template-columns: 1fr;
        }

        .topbar-pengurus {
            align-items: flex-start;
            gap: 10px;
        }

        .page-title-pengurus {
            font-size: 23px;
        }
    }
</style>


<div class="dashboard-pengurus">

    {{-- HEADER --}}
    <div class="topbar-pengurus">

        <div>
            <h1 class="page-title-pengurus">
                <i class="fa-solid fa-house"></i>
                Dashboard
            </h1>

            <div class="page-subtitle-pengurus">
                Selamat datang kembali,
                {{ $pengurus->nama ?? 'Pengurus RT' }} 👋
            </div>
        </div>

        <div class="date-box-pengurus">
            <i class="fa-regular fa-calendar"></i>
            {{ now()->translatedFormat('F Y') }}
        </div>

    </div>


    {{-- 4 CARD --}}
    <div class="stat-grid-pengurus">

        {{-- SALDO KAS --}}
        <div class="stat-card-pengurus">

            <div>
                <div class="stat-label">
                    SALDO KAS
                </div>

                <div class="stat-number">
                    Rp {{ number_format($saldoKas ?? 0, 0, ',', '.') }}
                </div>

                <div class="stat-desc">
                    Saldo kas saat ini
                </div>
            </div>

            <div class="stat-icon icon-green">
                <i class="fa-solid fa-wallet"></i>
            </div>

        </div>


        {{-- KAS MASUK --}}
        <div class="stat-card-pengurus">

            <div>
                <div class="stat-label">
                    KAS MASUK BULAN INI
                </div>

                <div class="stat-number">
                    Rp {{ number_format($kasMasukBulanIni ?? 0, 0, ',', '.') }}
                </div>

                <div class="stat-desc">
                    Total pemasukan
                </div>
            </div>

            <div class="stat-icon icon-blue">
                <i class="fa-solid fa-arrow-down"></i>
            </div>

        </div>


        {{-- PENGELUARAN --}}
        <div class="stat-card-pengurus">

            <div>
                <div class="stat-label">
                    TOTAL PENGELUARAN
                </div>

                <div class="stat-number">
                    Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}
                </div>

                <div class="stat-desc">
                    Total uang keluar
                </div>
            </div>

            <div class="stat-icon icon-red">
                <i class="fa-solid fa-arrow-up"></i>
            </div>

        </div>


        {{-- WARGA --}}
        <div class="stat-card-pengurus">

            <div>
                <div class="stat-label">
                    WARGA AKTIF
                </div>

                <div class="stat-number">
                    {{ $jumlahWarga ?? 0 }}
                </div>

                <div class="stat-desc">
                    Warga terdaftar
                </div>
            </div>

            <div class="stat-icon icon-orange">
                <i class="fa-solid fa-users"></i>
            </div>

        </div>

    </div>


    {{-- KONTEN --}}
    <div class="dashboard-grid">

        {{-- KAS MASUK TERBARU --}}
        <div class="dashboard-card">

            <div class="card-header-pengurus">

                <div>
                    <h2 class="card-title">
                        <i class="fa-solid fa-money-bill-wave"></i>
                        Kas Masuk Terbaru
                    </h2>

                    <div class="card-desc">
                        Daftar pemasukan kas terbaru
                    </div>
                </div>

                <a href="{{ route('pengurus.pembayaran.index') }}"
                   class="lihat-semua">
                    Lihat Semua
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </div>


            <div class="table-wrapper">

                <table class="table-pengurus">

                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Nominal</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($kasMasukTerbaru as $item)

                            <tr>

                                <td>
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                                </td>

                                <td class="nama-warga">
                                    {{ $item->keterangan ?? 'Pemasukan Kas' }}
                                </td>

                                <td class="nominal">
                                    Rp {{ number_format($item->jumlah ?? 0, 0, ',', '.') }}
                                </td>

                                <td>
                                    <span class="badge badge-masuk">
                                        <i class="fa-solid fa-circle-check"></i>
                                        Masuk
                                    </span>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="empty-data">

                                    <i class="fa-regular fa-folder-open"
                                       style="font-size:22px;"></i>

                                    <br><br>

                                    Belum ada pemasukan kas.

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- KANAN --}}
        <div class="side-content">

            {{-- AKSI CEPAT --}}
            <div class="dashboard-card">

                <h3 class="aksi-title">
                    <i class="fa-solid fa-bolt"
                       style="color:#f59e0b;"></i>
                    Aksi Cepat
                </h3>

                <p class="aksi-desc">
                    Kelola pembayaran kas warga dengan cepat.
                </p>

                <a href="{{ route('pengurus.pembayaran.create') }}"
                   class="btn-input">

                    <i class="fa-solid fa-plus"></i>
                    Input Pembayaran Tunai

                </a>

                <a href="{{ route('pengurus.pembayaran.index') }}"
                   class="quick-link">

                    <i class="fa-solid fa-clock-rotate-left"
                       style="color:#2563eb;"></i>

                    Riwayat Pembayaran

                </a>

            </div>


            {{-- RINGKASAN KAS --}}
            <div class="dashboard-card">

                <h3 class="aksi-title">
                    <i class="fa-solid fa-chart-pie"
                       style="color:#2563eb;"></i>
                    Ringkasan Kas
                </h3>

                <div class="summary-row">

                    <span class="summary-label">
                        Total Pemasukan
                    </span>

                    <span class="summary-value summary-pemasukan">
                        Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}
                    </span>

                </div>


                <div class="summary-row">

                    <span class="summary-label">
                        Total Pengeluaran
                    </span>

                    <span class="summary-value summary-pengeluaran">
                        Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}
                    </span>

                </div>


                <div class="summary-row">

                    <span class="summary-label">
                        Saldo Kas
                    </span>

                    <span class="summary-value summary-saldo">
                        Rp {{ number_format($saldoKas ?? 0, 0, ',', '.') }}
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection