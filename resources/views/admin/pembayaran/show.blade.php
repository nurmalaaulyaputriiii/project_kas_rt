@extends('layout.app')

@section('title', 'Verifikasi Pembayaran | SIKAS')

@section('content')

<style>
    .payment-detail-card {
        background: #fff;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, .06);
        height: 100%;
    }

    .section-title {
        font-size: 23px;
        font-weight: 700;
        color: #172b4d;
    }

    .detail-item {
        margin-bottom: 20px;
    }

    .detail-label {
        display: block;
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .detail-value {
        color: #172b4d;
        font-weight: 600;
        font-size: 16px;
    }

    .amount-value {
        color: #0d6efd;
        font-size: 25px;
        font-weight: 700;
    }

    .proof-box {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 15px;
        text-align: center;
    }

    .proof-image {
        width: 100%;
        max-height: 500px;
        object-fit: contain;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        cursor: pointer;
        background: #fff;
    }

    .proof-image:hover {
        opacity: .92;
    }

    .method-transfer {
        color: #0d6efd;
        font-weight: 700;
    }

    .method-tunai {
        color: #198754;
        font-weight: 700;
    }

    .btn-back {
        width: 100%;
    }

    @media (max-width: 991px) {
        .payment-detail-card {
            margin-bottom: 0;
        }
    }
</style>

{{-- Normalisasi metode pembayaran --}}
@php
    $metode = strtolower(trim($pembayaran->metode_pembayaran ?? ''));
    $isTransfer = $metode === 'transfer';
    $isTunai = $metode === 'tunai';

    // Kolom database yang benar adalah bukti_transfer
    $bukti = $pembayaran->bukti_transfer ?? null;
@endphp

{{-- TOPBAR --}}
<div class="topbar">
    <div>
        <h1 class="page-title">
            Verifikasi Pembayaran
        </h1>

        <div class="page-subtitle">
            Periksa pembayaran sebelum dikonfirmasi
        </div>
    </div>
</div>

{{-- CONTENT --}}
<div class="row g-4">

    {{-- ========================================================= --}}
    {{-- DETAIL PEMBAYARAN --}}
    {{-- ========================================================= --}}
    <div class="col-lg-6">

        <div class="payment-detail-card">

            <h3 class="section-title mb-4">
                Detail Pembayaran
            </h3>

            {{-- Nama Warga --}}
            <div class="detail-item">
                <span class="detail-label">
                    Nama Warga
                </span>

                <div class="detail-value fs-5">
                    {{ $pembayaran->warga->nama ?? '-' }}
                </div>
            </div>

            {{-- Nomor KK --}}
            <div class="detail-item">
                <span class="detail-label">
                    Nomor KK
                </span>

                <div class="detail-value">
                    {{ $pembayaran->no_kk ?? ($pembayaran->warga->no_kk ?? '-') }}
                </div>
            </div>

            {{-- Iuran --}}
            <div class="detail-item">
                <span class="detail-label">
                    Iuran
                </span>

                <div class="detail-value">
                    @if($pembayaran->kasBulanan)
                        {{ $pembayaran->kasBulanan->bulan }}
                        {{ $pembayaran->kasBulanan->tahun }}
                    @else
                        -
                    @endif
                </div>
            </div>

            {{-- Jumlah --}}
            <div class="detail-item">
                <span class="detail-label">
                    Jumlah Pembayaran
                </span>

                <div class="amount-value">
                    Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                </div>
            </div>

            {{-- Jenis Pembayaran --}}
            <div class="detail-item">
                <span class="detail-label">
                    Jenis Pembayaran dari Warga
                </span>

                <div>
                    @if($pembayaran->jenis_pembayaran === 'Lunas')

                        <span class="badge bg-success">
                            Lunas
                        </span>

                    @elseif($pembayaran->jenis_pembayaran === 'Cicilan')

                        <span class="badge bg-warning text-dark">
                            Cicilan
                        </span>

                    @else

                        <span class="badge bg-secondary">
                            -
                        </span>

                    @endif
                </div>
            </div>

            {{-- Metode Pembayaran --}}
            <div class="detail-item">
                <span class="detail-label">
                    Metode Pembayaran
                </span>

                <div>

                    @if($isTransfer)

                        <span class="method-transfer">
                            <i class="fa-solid fa-building-columns me-1"></i>
                            Transfer
                        </span>

                    @elseif($isTunai)

                        <span class="method-tunai">
                            <i class="fa-solid fa-money-bill-wave me-1"></i>
                            Tunai
                        </span>

                    @else

                        <span class="text-muted">
                            -
                        </span>

                    @endif

                </div>
            </div>

            {{-- Tanggal Bayar --}}
            <div class="detail-item">
                <span class="detail-label">
                    Tanggal Bayar
                </span>

                <div class="detail-value">
                    {{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d/m/Y H:i') }}
                </div>
            </div>

            {{-- Keterangan Warga --}}
            @if($pembayaran->keterangan)

                <div class="detail-item">

                    <span class="detail-label">
                        Keterangan dari Warga
                    </span>

                    <div class="detail-value">
                        {{ $pembayaran->keterangan }}
                    </div>

                </div>

            @endif

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- BUKTI TRANSFER + VERIFIKASI --}}
    {{-- ========================================================= --}}
    <div class="col-lg-6">

        <div class="payment-detail-card">

            {{-- ================================================= --}}
            {{-- TRANSFER --}}
            {{-- ================================================= --}}
            @if($isTransfer)

                <h3 class="section-title mb-3">

                    <i class="fa-solid fa-receipt me-2 text-primary"></i>

                    Bukti Transfer

                </h3>


                {{-- ================================================= --}}
                {{-- BUKTI TRANSFER --}}
                {{-- ================================================= --}}
                @if(!empty($bukti))

                    <div class="proof-box mb-4">

                        <a
                            href="{{ asset('storage/' . ltrim($bukti, '/')) }}"
                            target="_blank"
                        >

                            <img
                                src="{{ asset('storage/' . ltrim($bukti, '/')) }}"
                                alt="Bukti Transfer"
                                class="proof-image"
                            >

                        </a>


                        <div class="mt-3">

                            <a
                                href="{{ asset('storage/' . ltrim($bukti, '/')) }}"
                                target="_blank"
                                class="btn btn-outline-primary btn-sm"
                            >

                                <i class="fa-solid fa-up-right-from-square me-1"></i>

                                Lihat Bukti Penuh

                            </a>

                        </div>

                    </div>

                @else

                    <div class="alert alert-warning">

                        <i class="fa-solid fa-triangle-exclamation me-2"></i>

                        <strong>
                            Bukti transfer tidak ditemukan.
                        </strong>

                        <div class="small mt-1">

                            Data pembayaran menggunakan metode transfer,
                            tetapi file bukti pembayaran belum tersimpan.

                        </div>

                    </div>

                @endif


            {{-- ================================================= --}}
            {{-- TUNAI --}}
            {{-- ================================================= --}}
            @elseif($isTunai)

                <div class="alert alert-info">

                    <i class="fa-solid fa-money-bill-wave me-2"></i>

                    Pembayaran dilakukan secara
                    <strong>tunai</strong>.

                </div>


            {{-- ================================================= --}}
            {{-- METODE TIDAK DIKENALI --}}
            {{-- ================================================= --}}
            @else

                <div class="alert alert-danger">

                    <i class="fa-solid fa-circle-exclamation me-2"></i>

                    Metode pembayaran tidak dikenali.

                    <div class="small mt-1">

                        Nilai metode:

                        <strong>
                            {{ $pembayaran->metode_pembayaran ?? '-' }}
                        </strong>

                    </div>

                </div>

            @endif


            {{-- ================================================= --}}
            {{-- FORM VERIFIKASI --}}
            {{-- ================================================= --}}
            @if(
                $pembayaran->status === 'Menunggu Verifikasi' ||
                $pembayaran->status === 'Menunggu Konfirmasi'
            )

                <hr class="my-4">


                <h3 class="section-title mb-3">
                    Verifikasi Pembayaran
                </h3>


                <form
                    action="{{ route('admin.pembayaran.verifikasi', $pembayaran->id) }}"
                    method="POST"
                >

                    @csrf
                    @method('PATCH')


                    {{-- HASIL VERIFIKASI --}}
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Hasil Verifikasi
                        </label>

                        <select
                            name="status"
                            class="form-select"
                            required
                        >

                            <option value="">
                                -- Pilih Hasil Verifikasi --
                            </option>

                            <option value="Lunas">
                                Lunas
                            </option>

                            <option value="Cicilan">
                                Cicilan
                            </option>

                            <option value="Ditolak">
                                Ditolak
                            </option>

                        </select>

                        @error('status')

                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- KETERANGAN ADMIN --}}
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Keterangan Admin
                        </label>

                        <textarea
                            name="keterangan_admin"
                            class="form-control"
                            rows="3"
                            placeholder="Contoh: Pembayaran telah diterima."
                        >{{ old('keterangan_admin') }}</textarea>

                        @error('keterangan_admin')

                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- TOMBOL VERIFIKASI --}}
                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                    >

                        <i class="fa-solid fa-check-circle me-2"></i>

                        Verifikasi Pembayaran

                    </button>

                </form>

            @else

                <hr class="my-4">


                <div class="alert alert-success">

                    <i class="fa-solid fa-circle-check me-2"></i>

                    Pembayaran ini sudah diverifikasi sebagai

                    <strong>
                        {{ $pembayaran->status }}
                    </strong>.

                    @if($pembayaran->verified_by_name)

                        <div class="small mt-2">

                            Diverifikasi oleh:
                            <strong>
                                {{ $pembayaran->verified_by_name }}
                            </strong>

                            @if($pembayaran->verified_by_role)
                                ({{ $pembayaran->verified_by_role }})
                            @endif

                        </div>

                    @endif

                </div>

            @endif


            {{-- KEMBALI --}}
            <a
                href="{{ route('admin.pembayaran.index') }}"
                class="btn btn-secondary btn-back mt-3"
            >

                <i class="fa-solid fa-arrow-left me-2"></i>

                Kembali

            </a>

        </div>

    </div>

</div>

@endsection