@extends('layout.warga')

@section('title', 'Pengumuman RT | SI-KAS RT')

@section('content')

<style>
    .announcement-header {
        background: linear-gradient(135deg, #1976ed, #0752b7);
        border-radius: 18px;
        padding: 28px 30px;
        color: white;
        margin-bottom: 25px;
        box-shadow: 0 8px 20px rgba(25, 118, 237, 0.18);
    }

    .announcement-header-content {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .announcement-header-icon {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.18);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
        flex-shrink: 0;
    }

    .announcement-header h4 {
        font-size: 20px;
        font-weight: 700;
        margin: 0 0 5px;
    }

    .announcement-header p {
        margin: 0;
        font-size: 13px;
        opacity: 0.85;
    }

    .announcement-container {
        background: white;
        border-radius: 18px;
        padding: 28px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
    }

    .announcement-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 22px;
    }

    .announcement-title h3 {
        font-size: 19px;
        font-weight: 700;
        margin: 0;
    }

    .announcement-title p {
        color: #888;
        font-size: 12px;
        margin: 5px 0 0;
    }

    .announcement-card {
        position: relative;
        background: #fff;
        border: 1px solid #e8edf3;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 15px;
        transition: all 0.25s ease;
        overflow: hidden;
    }

    .announcement-card::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #2563eb;
    }

    .announcement-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 20px rgba(0,0,0,0.07);
        border-color: #dbeafe;
    }

    .announcement-card:last-child {
        margin-bottom: 0;
    }

    .announcement-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
    }

    .announcement-heading {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .announcement-icon {
        width: 42px;
        height: 42px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .announcement-heading h5 {
        font-size: 15px;
        font-weight: 700;
        color: #222;
        margin: 0;
    }

    .announcement-badge {
        background: #eff6ff;
        color: #2563eb;
        font-size: 10px;
        font-weight: 600;
        padding: 6px 10px;
        border-radius: 20px;
        white-space: nowrap;
    }

    .announcement-content {
        margin: 16px 0 0 54px;
        color: #555;
        font-size: 13px;
        line-height: 1.7;
    }

    .announcement-date {
        margin: 15px 0 0 54px;
        padding-top: 12px;
        border-top: 1px solid #f0f0f0;
        color: #999;
        font-size: 11px;
    }

    .empty-announcement {
        text-align: center;
        padding: 55px 20px;
        border: 1px dashed #dce2ea;
        border-radius: 15px;
        background: #fafcff;
    }

    .empty-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 15px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 27px;
    }

    .empty-announcement h5 {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .empty-announcement p {
        color: #999;
        font-size: 12px;
        margin: 0;
    }

    @media (max-width: 600px) {

        .announcement-header {
            padding: 22px;
        }

        .announcement-container {
            padding: 20px;
        }

        .announcement-top {
            flex-direction: column;
        }

        .announcement-content,
        .announcement-date {
            margin-left: 0;
        }

    }
</style>


<div class="topbar">

    <div>
        <h1 class="page-title">
            Pengumuman Warga
        </h1>

        <div class="page-subtitle">
            Informasi terbaru dari pengurus
        </div>
    </div>

</div>


{{-- HEADER --}}

<div class="announcement-header">

    <div class="announcement-header-content">

        <div class="announcement-header-icon">
            <i class="fa-solid fa-bullhorn"></i>
        </div>

        <div>

            <h4>
                Informasi Warga
            </h4>

            <p>
                Pantau pengumuman dan informasi terbaru dari pengurus RT.
            </p>

        </div>

    </div>

</div>


{{-- DAFTAR PENGUMUMAN --}}

<div class="announcement-container">

    <div class="announcement-title">

        <div>

            <h3>
                Pengumuman Terbaru
            </h3>

            <p>
                Informasi yang disampaikan oleh pengurus RT
            </p>

        </div>

    </div>


    @forelse($pengumuman as $item)

        <div class="announcement-card">

            <div class="announcement-top">

                <div class="announcement-heading">

                    <div class="announcement-icon">

                        <i class="fa-solid fa-bullhorn"></i>

                    </div>

                    <h5>
                        {{ $item->judul }}
                    </h5>

                </div>


                <span class="announcement-badge">
                    Pengumuman
                </span>

            </div>


            <div class="announcement-content">

                {{ $item->isi }}

            </div>


            <div class="announcement-date">

                <i class="fa-regular fa-calendar me-1"></i>

                {{ $item->created_at
                    ? $item->created_at->format('d F Y, H:i')
                    : '-' }}

            </div>

        </div>

    @empty

        <div class="empty-announcement">

            <div class="empty-icon">

                <i class="fa-solid fa-bullhorn"></i>

            </div>

            <h5>
                Belum Ada Pengumuman
            </h5>

            <p>
                Belum ada informasi atau pengumuman dari pengurus.
            </p>

        </div>

    @endforelse

</div>

@endsection