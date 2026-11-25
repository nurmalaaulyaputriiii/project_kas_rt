@extends('layout.warga')

@section('title', 'Laporan Pengeluaran | SIKAS')

@section('content')

<style>
    .laporan-page {
        width: 100%;
    }

    .laporan-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        gap: 15px;
    }

    .laporan-title {
        font-size: 28px;
        font-weight: 700;
        color: #172033;
        margin: 0 0 5px;
    }

    .laporan-subtitle {
        font-size: 14px;
        color: #718096;
    }

    .filter-card {
        background: #ffffff;
        border-radius: 15px;
        padding: 24px;
        margin-bottom: 25px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, .06);
    }

    .filter-title {
        font-size: 18px;
        font-weight: 700;
        color: #172033;
        margin-bottom: 18px;
    }

    .filter-label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 7px;
    }

    .filter-control {
        width: 100%;
        height: 44px;
        border: 1px solid #dbe1e8;
        border-radius: 9px;
        padding: 8px 12px;
        font-size: 14px;
        background: #fff;
    }

    .filter-control:focus {
        outline: none;
        border-color: #1677f2;
        box-shadow: 0 0 0 3px rgba(22, 119, 242, .1);
    }

    .btn-filter {
        height: 44px;
        width: 100%;
        border: none;
        border-radius: 9px;
        background: #1677f2;
        color: white;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-filter:hover {
        background: #075fcf;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }

    .summary-card {
        background: white;
        border-radius: 15px;
        padding: 22px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, .06);
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 120px;
    }

    .summary-label {
        font-size: 12px;
        font-weight: 600;
        color: #718096;
        margin-bottom: 7px;
        text-transform: uppercase;
    }

    .summary-value {
        font-size: 23px;
        font-weight: 800;
        color: #172033;
        line-height: 1.3;
    }

    .summary-desc {
        font-size: 12px;
        color: #9ca3af;
        margin-top: 5px;
    }

    .summary-icon {
        width: 54px;
        height: 54px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .icon-red {
        background: #fef2f2;
        color: #dc2626;
    }

    .icon-blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .report-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, .06);
        overflow: hidden;
        margin-bottom: 25px;
    }

    .report-card-header {
        padding: 23px 25px;
        border-bottom: 1px solid #edf0f4;
    }

    .report-card-title {
        font-size: 19px;
        font-weight: 700;
        color: #172033;
        margin: 0 0 4px;
    }

    .report-card-subtitle {
        font-size: 13px;
        color: #718096;
    }

    .report-table-wrap {
        padding: 0 25px 25px;
        overflow-x: auto;
    }

    .report-table {
        width: 100%;
        min-width: 650px;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .report-table th {
        background: #1677f2;
        color: white;
        padding: 14px 15px;
        font-size: 13px;
        font-weight: 600;
        text-align: left;
        white-space: nowrap;
    }

    .report-table td {
        padding: 15px;
        font-size: 13px;
        color: #374151;
        border-bottom: 1px solid #edf0f4;
        vertical-align: middle;
    }

    .report-table tbody tr:hover {
        background: #f8fbff;
    }

    .report-table tbody tr:last-child td {
        border-bottom: none;
    }

    .nominal-keluar {
        color: #dc2626;
        font-weight: 700;
        white-space: nowrap;
    }

    .tanggal {
        white-space: nowrap;
        color: #667085;
    }

    .empty-row {
        text-align: center;
        padding: 45px 20px !important;
        color: #94a3b8;
    }

    .empty-row i {
        font-size: 35px;
        margin-bottom: 12px;
        display: block;
    }

    .period-box {
        background: #eff6ff;
        border: 1px solid #dbeafe;
        color: #1d4ed8;
        border-radius: 9px;
        padding: 10px 14px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 15px;
    }

    @media (max-width: 800px) {
        .summary-grid {
            grid-template-columns: 1fr;
        }

        .laporan-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 700px) {
        .filter-card {
            padding: 18px;
        }

        .report-card-header {
            padding: 20px;
        }

        .report-table-wrap {
            padding: 0 20px 20px;
        }

        .laporan-title {
            font-size: 23px;
        }
    }
</style>

<div class="laporan-page">

    {{-- HEADER --}}
    <div class="laporan-header">
        <div>
            <h1 class="laporan-title">
                Laporan Pengeluaran
            </h1>

            <div class="laporan-subtitle">
                Informasi pengeluaran kas yang dapat dilihat oleh warga
            </div>
        </div>
    </div>


    {{-- FILTER --}}
    <div class="filter-card">

        <div class="filter-title">
            <i class="fa-solid fa-filter me-2"></i>
            Filter Laporan
        </div>

        <form
            action="{{ route('warga.laporan.pengeluaran') }}"
            method="GET"
        >

            <div class="row g-3 align-items-end">

                {{-- BULAN --}}
                <div class="col-md-5">

                    <label class="filter-label">
                        Bulan
                    </label>

                    <select
                        name="bulan"
                        class="filter-control"
                    >
                        <option value="">
                            Semua Bulan
                        </option>

                        @for($i = 1; $i <= 12; $i++)

                            <option
                                value="{{ $i }}"
                                {{ (string) $bulan === (string) $i ? 'selected' : '' }}
                            >
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>

                        @endfor

                    </select>

                </div>


                {{-- TAHUN --}}
                <div class="col-md-4">

                    <label class="filter-label">
                        Tahun
                    </label>

                    <select
                        name="tahun"
                        class="filter-control"
                    >

                        <option value="">
                            Semua Tahun
                        </option>

                        @foreach($tahunList as $item)

                            <option
                                value="{{ $item }}"
                                {{ (string) $tahun === (string) $item ? 'selected' : '' }}
                            >
                                {{ $item }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- BUTTON --}}
                <div class="col-md-3">

                    <button
                        type="submit"
                        class="btn-filter"
                    >
                        <i class="fa-solid fa-magnifying-glass me-2"></i>
                        Tampilkan
                    </button>

                </div>

            </div>

        </form>


        @if($bulan || $tahun)

            <div class="period-box">

                <i class="fa-solid fa-calendar-days"></i>

                Periode:

                @if($bulan)
                    {{ \Carbon\Carbon::create()->month((int) $bulan)->translatedFormat('F') }}
                @else
                    Semua Bulan
                @endif

                @if($tahun)
                    {{ $tahun }}
                @else
                    Semua Tahun
                @endif

            </div>

        @endif

    </div>


    {{-- RINGKASAN --}}
    <div class="summary-grid">

        {{-- TOTAL PENGELUARAN --}}
        <div class="summary-card">

            <div>

                <div class="summary-label">
                    Total Pengeluaran
                </div>

                <div class="summary-value">
                    Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                </div>

                <div class="summary-desc">
                    Total pengeluaran sesuai filter
                </div>

            </div>

            <div class="summary-icon icon-red">

                <i class="fa-solid fa-arrow-up"></i>

            </div>

        </div>


        {{-- JUMLAH TRANSAKSI --}}
        <div class="summary-card">

            <div>

                <div class="summary-label">
                    Jumlah Transaksi
                </div>

                <div class="summary-value">
                    {{ $jumlahTransaksi }}
                </div>

                <div class="summary-desc">
                    Transaksi pengeluaran kas
                </div>

            </div>

            <div class="summary-icon icon-blue">

                <i class="fa-solid fa-receipt"></i>

            </div>

        </div>

    </div>


    {{-- DATA PENGELUARAN --}}
    <div class="report-card">

        <div class="report-card-header">

            <h2 class="report-card-title">

                <i class="fa-solid fa-arrow-up text-danger me-2"></i>

                Data Pengeluaran

            </h2>

            <div class="report-card-subtitle">

                Daftar pengeluaran kas pada periode yang dipilih

            </div>

        </div>


        <div class="report-table-wrap">

            <table class="report-table">

                <thead>

                    <tr>

                        <th style="width: 60px;">
                            No
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Keperluan
                        </th>

                        <th>
                            Jumlah
                        </th>

                        <th>
                            Keterangan
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($pengeluaran as $item)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td class="tanggal">

                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}

                            </td>

                            <td>
                                {{ $item->keperluan }}
                            </td>

                            <td class="nominal-keluar">

                                Rp {{ number_format($item->jumlah, 0, ',', '.') }}

                            </td>

                            <td>
                                {{ $item->keterangan ?? '-' }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="empty-row"
                            >

                                <i class="fa-solid fa-receipt"></i>

                                <strong>
                                    Belum Ada Data Pengeluaran
                                </strong>

                                <div class="small mt-1">
                                    Belum ada pengeluaran kas pada periode ini.
                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection