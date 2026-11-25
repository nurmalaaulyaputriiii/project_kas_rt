@extends('layout.pengurus')

@section('title', 'Pembayaran Iuran | SI-KAS RT')

@section('content')

<style>
    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .page-title {
        margin: 0;
        font-size: 27px;
        font-weight: 700;
        color: #1f2937;
    }

    .page-subtitle {
        color: #6b7280;
        margin-top: 5px;
    }

    .card-custom {
        background: #fff;
        border-radius: 14px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,.06);
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .section-subtitle {
        color: #6b7280;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #2563eb;
        color: white;
        text-decoration: none;
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        border: none;
    }

    .btn-primary:hover {
        background: #1d4ed8;
        color: white;
    }

    .btn-warning {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f59e0b;
        color: white;
        text-decoration: none;
        padding: 8px 13px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }

    .btn-warning:hover {
        background: #d97706;
        color: white;
    }

    .badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-success {
        background: #dcfce7;
        color: #166534;
    }

    .badge-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-info {
        background: #dbeafe;
        color: #1e40af;
    }

    .table-wrapper {
        overflow-x: auto;
        margin-top: 25px;
    }

    .payment-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1100px;
    }

    .payment-table th {
        padding: 14px;
        text-align: left;
        background: #f7fafc;
        border-bottom: 1px solid #e2e8f0;
        color: #374151;
        font-size: 13px;
    }

    .payment-table td {
        padding: 14px;
        border-bottom: 1px solid #edf2f7;
        color: #374151;
        font-size: 13px;
        vertical-align: middle;
    }

    .payment-table tr:hover {
        background: #fafafa;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #718096;
    }

    .empty-state i {
        font-size: 50px;
        opacity: .4;
        margin-bottom: 15px;
    }

    .alert-success {
        background: #f0fff4;
        color: #276749;
        padding: 15px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .alert-error {
        background: #fff5f5;
        color: #c53030;
        padding: 15px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .verified-info {
        font-size: 11px;
        color: #6b7280;
        margin-top: 5px;
    }
</style>


{{-- =========================================================
     HEADER
========================================================= --}}

<div class="topbar">

    <div>

        <h1 class="page-title">
            Pembayaran Iuran
        </h1>

        <div class="page-subtitle">
            Periksa dan verifikasi pembayaran iuran warga
        </div>

    </div>


    <div>

        <a
            href="{{ route('pengurus.pembayaran.create') }}"
            class="btn-primary"
        >
            <i class="fa-solid fa-plus"></i>
            Input Pembayaran
        </a>

    </div>

</div>


{{-- =========================================================
     NOTIFIKASI
========================================================= --}}

@if (session('success'))

    <div class="alert-success">

        <i class="fa-solid fa-circle-check me-2"></i>

        {{ session('success') }}

    </div>

@endif


@if (session('error'))

    <div class="alert-error">

        <i class="fa-solid fa-circle-exclamation me-2"></i>

        {{ session('error') }}

    </div>

@endif


{{-- =========================================================
     DAFTAR PEMBAYARAN
========================================================= --}}

<div class="card-custom">

    <div class="section-title">
        Daftar Pembayaran
    </div>

    <div class="section-subtitle">
        Periksa dan verifikasi pembayaran iuran warga
    </div>


    @if ($pembayarans->count())

        <div class="table-wrapper">

            <table class="payment-table">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Warga</th>

                        <th>Iuran</th>

                        <th>Tanggal Bayar</th>

                        <th>Jumlah</th>

                        <th>Jenis</th>

                        <th>Metode</th>

                        <th>Status</th>

                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    @foreach ($pembayarans as $pembayaran)

                        <tr>

                            {{-- NO --}}

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            {{-- WARGA --}}

                            <td>

                                <div style="font-weight:600;">

                                    {{ $pembayaran->warga->nama ?? '-' }}

                                </div>

                                @if ($pembayaran->no_kk)

                                    <div
                                        style="
                                            font-size:12px;
                                            color:#718096;
                                            margin-top:4px;
                                        "
                                    >

                                        KK:
                                        {{ $pembayaran->no_kk }}

                                    </div>

                                @endif

                            </td>


                            {{-- IURAN --}}

                            <td>

                                @if ($pembayaran->kasBulanan)

                                    <strong>
                                        {{ $pembayaran->kasBulanan->bulan }}
                                    </strong>

                                    <br>

                                    Tahun
                                    {{ $pembayaran->kasBulanan->tahun }}

                                @else

                                    -

                                @endif

                            </td>


                            {{-- TANGGAL --}}

                            <td>

                                @if ($pembayaran->tanggal_bayar)

                                    {{ $pembayaran->tanggal_bayar->format('d/m/Y') }}

                                    <br>

                                    <span style="color:#718096;">
                                        {{ $pembayaran->tanggal_bayar->format('H:i') }}
                                    </span>

                                @else

                                    -

                                @endif

                            </td>


                            {{-- JUMLAH --}}

                            <td>

                                <strong>

                                    Rp
                                    {{ number_format(
                                        $pembayaran->jumlah,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </strong>

                            </td>


                            {{-- JENIS --}}

                            <td>

                                @if ($pembayaran->jenis_pembayaran === 'Lunas')

                                    <span class="badge badge-success">
                                        Lunas
                                    </span>

                                @elseif ($pembayaran->jenis_pembayaran === 'Cicilan')

                                    <span class="badge badge-warning">
                                        Cicilan
                                    </span>

                                @elseif ($pembayaran->status === 'Ditolak')

                                    <span class="badge badge-danger">
                                        Ditolak
                                    </span>

                                @else

                                    <span class="badge badge-warning">
                                        {{ $pembayaran->jenis_pembayaran ?? '-' }}
                                    </span>

                                @endif

                            </td>


                            {{-- METODE --}}

                            <td>

                                @if (
                                    strtolower(
                                        $pembayaran->metode_pembayaran
                                    ) === 'transfer'
                                )

                                    <span class="badge badge-info">
                                        Transfer
                                    </span>

                                @else

                                    <span class="badge badge-success">
                                        Tunai
                                    </span>

                                @endif

                            </td>


                            {{-- STATUS --}}

                            <td>

                                @if (
                                    in_array(
                                        $pembayaran->status,
                                        [
                                            'Menunggu Verifikasi',
                                            'Menunggu Konfirmasi'
                                        ]
                                    )
                                )

                                    <span class="badge badge-warning">

                                        {{ $pembayaran->status }}

                                    </span>

                                @elseif ($pembayaran->status === 'Ditolak')

                                    <span class="badge badge-danger">
                                        Ditolak
                                    </span>

                                @else

                                    <span class="badge badge-success">

                                        {{ $pembayaran->status }}

                                    </span>

                                    @if ($pembayaran->verified_by_name)

                                        <div class="verified-info">

                                            Diverifikasi oleh:
                                            <strong>
                                                {{ $pembayaran->verified_by_name }}
                                            </strong>

                                        </div>

                                    @endif

                                @endif

                            </td>


                            {{-- AKSI --}}

                            <td>

                                @if (
                                    strtolower(
                                        $pembayaran->metode_pembayaran
                                    ) === 'transfer'
                                    &&
                                    in_array(
                                        $pembayaran->status,
                                        [
                                            'Menunggu Verifikasi',
                                            'Menunggu Konfirmasi'
                                        ]
                                    )
                                )

                                    <a
                                        href="{{ route(
                                            'pengurus.pembayaran.verifikasi',
                                            $pembayaran->id
                                        ) }}"
                                        class="btn-warning"
                                    >

                                        <i class="fa-solid fa-eye"></i>

                                        Periksa & Verifikasi

                                    </a>

                                @else

                                    <span
                                        style="
                                            color:#718096;
                                            font-size:12px;
                                        "
                                    >
                                        Sudah diverifikasi
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="empty-state">

            <i class="fa-solid fa-receipt"></i>

            <div
                style="
                    font-size:18px;
                    font-weight:600;
                    color:#4a5568;
                    margin-bottom:8px;
                "
            >
                Belum Ada Pembayaran
            </div>

            <div style="margin-bottom:22px;">
                Belum ada pembayaran iuran warga.
            </div>

            <a
                href="{{ route('pengurus.pembayaran.create') }}"
                class="btn-primary"
            >

                <i class="fa-solid fa-plus"></i>

                Input Pembayaran

            </a>

        </div>

    @endif

</div>

@endsection