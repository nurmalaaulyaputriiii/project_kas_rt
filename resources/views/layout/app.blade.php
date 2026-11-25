<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SIKAS')</title>

    <!-- Bootstrap -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    >

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    >

    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            color: #172033;
        }

        /* ================= SIDEBAR ================= */

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 250px;
            padding: 30px 20px;
            background: linear-gradient(180deg, #1677f2, #0752b7);
            color: white;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .logo {
            font-size: 30px;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 14px;
            opacity: .9;
            margin-bottom: 45px;
        }

        .menu-title {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            opacity: .75;
            margin: 25px 10px 10px;
        }

        .menu {
            display: flex;
            align-items: center;
            gap: 13px;
            color: white;
            text-decoration: none;
            padding: 13px 12px;
            border-radius: 8px;
            margin-bottom: 4px;
            font-size: 16px;
            transition: .2s;
        }

        .menu:hover,
        .menu.active {
            background: rgba(255, 255, 255, .17);
            color: white;
        }

        .menu i {
            width: 22px;
        }

        /* Mendorong Profil & Logout ke bawah */

        .menu-spacer {
            flex: 1;
            min-height: 30px;
        }

        /* ================= MAIN ================= */

        .main {
            margin-left: 250px;
            padding: 35px;
            width: calc(100% - 250px);
            min-height: 100vh;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 32px;
            font-weight: 800;
            margin: 0;
        }

        .page-subtitle {
            color: #718096;
            margin-top: 5px;
        }

        .date-box {
            background: #dceaff;
            color: #1263d7;
            border-radius: 8px;
            padding: 12px 18px;
            font-weight: bold;
        }

        /* ================= CARDS ================= */

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 25px;
        }

        .card-custom {
            background: white;
            border-radius: 10px;
            padding: 28px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, .06);
        }

        .stat-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            min-height: 150px;
        }

        .stat-title {
            color: #718096;
            font-size: 17px;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 34px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .stat-desc {
            color: #718096;
        }

        .icon-box {
            width: 68px;
            height: 120px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .blue {
            background: #d4e5ff;
            color: #1677f2;
        }

        .green {
            background: #d5eee4;
            color: #15966a;
        }

        .yellow {
            background: #fff0bd;
            color: #efa900;
        }

        /* ================= DASHBOARD ================= */

        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 800;
        }

        .section-subtitle {
            color: #718096;
            margin-bottom: 20px;
        }

        .summary-item {
            margin: 25px 0;
        }

        .summary-label {
            color: #718096;
            margin-bottom: 6px;
        }

        .summary-value {
            font-size: 27px;
            font-weight: 800;
        }

        .green-text {
            color: #129b68;
        }

        .red-text {
            color: #e73446;
        }

        /* ================= TABLE ================= */

        .table-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, .06);
        }

        .table thead th {
            background: #1677f2;
            color: white;
            padding: 16px;
            border: 0;
        }

        .table tbody td {
            padding: 16px;
            vertical-align: middle;
        }

        /* ================= BUTTON ================= */

        .btn-primary-custom {
            background: #1677f2;
            border: none;
            color: white;
            border-radius: 9px;
            padding: 12px 20px;
        }

        .btn-primary-custom:hover {
            background: #075fcf;
            color: white;
        }

        .status-active {
            color: green;
            font-weight: bold;
        }

        /* ================= FORM ================= */

        .form-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, .06);
            width: 100%;
            max-width: none;
        }

        /*
         * Memastikan card form memenuhi seluruh
         * area content meskipun halaman memiliki
         * CSS .form-card sendiri.
         */

        .main .form-card {
            width: 100%;
            max-width: none;
        }

        /* ================= RESPONSIVE ================= */

        @media (max-width: 1000px) {

            .sidebar {
                width: 210px;
            }

            .main {
                margin-left: 210px;
                width: calc(100% - 210px);
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 700px) {

            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }

            .main {
                margin-left: 0;
                width: 100%;
                padding: 20px;
            }

            .menu-spacer {
                display: none;
            }

            .form-card {
                width: 100%;
                max-width: none;
            }

        }

    </style>

</head>

<body>

    <!-- ===================================================== -->
    <!-- SIDEBAR -->
    <!-- ===================================================== -->

    <aside class="sidebar">

        <!-- LOGO -->

        <div class="logo">
            SIKAS
        </div>

        <div class="subtitle">
            Sistem Iuran Warga
        </div>


        <!-- ================= MENU ================= -->

        <div class="menu-title">
            Menu
        </div>

        <!-- Dashboard -->

        <a
            href="{{ route('admin.dashboard') }}"
            class="menu {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-house"></i>
            Dashboard
        </a>


        <!-- Data Warga -->

        <a
            href="{{ route('admin.warga.index') }}"
            class="menu {{ request()->routeIs('admin.warga.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-users"></i>
            Data Warga
        </a>


        <!-- ================= TRANSAKSI ================= -->

        <div class="menu-title">
            Transaksi
        </div>


        <!-- Kas Bulanan -->

        <a
            href="{{ route('admin.kas.index') }}"
            class="menu {{ request()->routeIs('admin.kas.*') ? 'active' : '' }}"
        >
            <i class="fa-regular fa-calendar-check"></i>
            Kas Bulanan
        </a>


        <!-- Pembayaran -->

        <a
            href="{{ route('admin.pembayaran.index') }}"
            class="menu {{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}"
        >
            <i class="fa-regular fa-credit-card"></i>
            Pembayaran Iuran
        </a>


        <!-- Pemasukan -->

        <a
            href="{{ route('admin.pemasukan.index') }}"
            class="menu {{ request()->routeIs('admin.pemasukan.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-money-bill-transfer"></i>
            Pemasukan
        </a>


        <!-- Pengeluaran -->

        <a
            href="{{ route('admin.pengeluaran.index') }}"
            class="menu {{ request()->routeIs('admin.pengeluaran.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-wallet"></i>
            Pengeluaran
        </a>


        <!-- Laporan -->

        <a
            href="{{ route('admin.laporan') }}"
            class="menu {{ request()->routeIs('admin.laporan') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-file-lines"></i>
            Laporan
        </a>


        <!-- ================= INFORMASI ================= -->

        <div class="menu-title">
            Informasi
        </div>


        <!-- Pengumuman -->

        <a
            href="{{ route('admin.pengumuman.index') }}"
            class="menu {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-bullhorn"></i>
            Pengumuman
        </a>


        <!-- Pengurus -->

        <a
            href="{{ route('admin.pengurus.index') }}"
            class="menu {{ request()->routeIs('admin.pengurus.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-user-tie"></i>
            Pengurus
        </a>


        <!-- Spacer supaya menu akun turun -->

        <div class="menu-spacer"></div>


        <!-- ================= AKUN ================= -->

        <div class="menu-title">
            Akun
        </div>


        <!-- Profil -->

        <a
            href="{{ route('admin.profil') }}"
            class="menu {{ request()->routeIs('admin.profil') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-user"></i>
            Profil
        </a>


        <!-- Logout -->

        <a
            href="{{ route('admin.logout') }}"
            class="menu"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
        >
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </a>


        <!-- Form Logout -->

        <form
            id="logout-form"
            action="{{ route('admin.logout') }}"
            method="POST"
            style="display: none;"
        >
            @csrf
        </form>

    </aside>


    <!-- ===================================================== -->
    <!-- MAIN CONTENT -->
    <!-- ===================================================== -->

    <main class="main">

        <!-- Success Alert -->

        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif


        <!-- Error Alert -->

        @if($errors->any())

            <div class="alert alert-danger">

                <ul class="mb-0">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <!-- Isi halaman -->

        @yield('content')

    </main>


    <!-- Bootstrap JS -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>


    <!-- Script halaman -->

    @yield('script')

</body>

</html>