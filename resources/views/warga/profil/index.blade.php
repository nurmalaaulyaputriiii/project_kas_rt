@extends('layout.warga')

@section('title', 'Profil Warga | SI-KAS RT')

@section('content')

<style>
    .profile-wrapper {
        max-width: 850px;
        margin: 0 auto;
    }

    .profile-card {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #edf0f5;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
    }

    .profile-header {
        padding: 32px;
        background: linear-gradient(135deg, #134e8e, #2563a8);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .profile-header::after {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        right: -55px;
        top: -80px;
    }

    .profile-header::before {
        content: "";
        position: absolute;
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.06);
        right: 100px;
        bottom: -70px;
    }

    .profile-icon {
        width: 70px;
        height: 70px;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.18);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        margin-bottom: 18px;
        position: relative;
        z-index: 1;
    }

    .profile-header h2 {
        margin: 0 0 6px;
        font-size: 24px;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }

    .profile-header p {
        margin: 0;
        font-size: 13px;
        opacity: 0.85;
        position: relative;
        z-index: 1;
    }

    .profile-body {
        padding: 30px 32px;
    }

    .section-title-custom {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .section-subtitle-custom {
        color: #8a93a3;
        font-size: 13px;
        margin-bottom: 25px;
    }

    .profile-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .info-box {
        background: #f8fafc;
        border: 1px solid #edf1f5;
        border-radius: 15px;
        padding: 19px 20px;
        transition: 0.2s;
    }

    .info-box:hover {
        border-color: #d8e5f2;
        transform: translateY(-2px);
    }

    .info-label {
        color: #7b8494;
        font-size: 12px;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .info-content {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-icon {
        width: 38px;
        height: 38px;
        border-radius: 11px;
        background: #e8f1fb;
        color: #134e8e;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 17px;
    }

    .info-value {
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
        word-break: break-word;
    }

    .status-active {
        color: #16a34a;
    }

    .status-inactive {
        color: #dc2626;
    }

    .profile-footer {
        margin-top: 25px;
        padding: 16px 18px;
        border-radius: 13px;
        background: #f8fafc;
        color: #7b8494;
        font-size: 12px;
        text-align: center;
    }

    @media (max-width: 768px) {

        .profile-wrapper {
            max-width: 100%;
        }

        .profile-header {
            padding: 25px 22px;
        }

        .profile-body {
            padding: 24px 20px;
        }

        .profile-info {
            grid-template-columns: 1fr;
        }

        .profile-header h2 {
            font-size: 21px;
        }
    }
</style>

<div class="topbar">
    <div>
        <h1 class="page-title">
            Profil Warga
        </h1>

        <div class="page-subtitle">
            Informasi akun dan data kepala keluarga
        </div>
    </div>
</div>

<div class="profile-wrapper">

    <div class="profile-card">

        {{-- HEADER PROFIL --}}
        <div class="profile-header">

            <div class="profile-icon">
                👤
            </div>

            <h2>
                {{ $warga->nama }}
            </h2>

            <p>
                Kepala Keluarga
            </p>

        </div>

        {{-- ISI PROFIL --}}
        <div class="profile-body">

            <div class="section-title-custom">
                Informasi Warga
            </div>

            <div class="section-subtitle-custom">
                Berikut adalah informasi akun warga yang sedang login.
            </div>

            <div class="profile-info">

                {{-- NAMA --}}
                <div class="info-box">

                    <div class="info-label">
                        Nama Kepala Keluarga
                    </div>

                    <div class="info-content">

                        <div class="info-icon">
                            👤
                        </div>

                        <div class="info-value">
                            {{ $warga->nama }}
                        </div>

                    </div>

                </div>

                {{-- NO KK --}}
                <div class="info-box">

                    <div class="info-label">
                        Nomor Kartu Keluarga
                    </div>

                    <div class="info-content">

                        <div class="info-icon">
                            🪪
                        </div>

                        <div class="info-value">
                            {{ $warga->no_kk }}
                        </div>

                    </div>

                </div>

                {{-- NO HP --}}
                <div class="info-box">

                    <div class="info-label">
                        Nomor Handphone
                    </div>

                    <div class="info-content">

                        <div class="info-icon">
                            📱
                        </div>

                        <div class="info-value">
                            {{ $warga->no_hp ?? '-' }}
                        </div>

                    </div>

                </div>

                {{-- STATUS --}}
                <div class="info-box">

                    <div class="info-label">
                        Status Warga
                    </div>

                    <div class="info-content">

                        <div class="info-icon">
                            ✓
                        </div>

                        <div class="info-value">

                            @if($warga->status == 'Aktif')

                                <span class="status-active">
                                    Aktif
                                </span>

                            @else

                                <span class="status-inactive">
                                    Tidak Aktif
                                </span>

                            @endif

                        </div>

                    </div>

                </div>

                {{-- ALAMAT --}}
                <div class="info-box">

                    <div class="info-label">
                        Alamat
                    </div>

                    <div class="info-content">

                        <div class="info-icon">
                            📍
                        </div>

                        <div class="info-value">
                            {{ $warga->alamat ?? '-' }}
                        </div>

                    </div>

                </div>

            </div>

            <div class="profile-footer">
                🔒 Informasi akun ini hanya dapat dilihat oleh warga yang sedang login.
            </div>

        </div>

    </div>

</div>

@endsection