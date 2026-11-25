<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'SIKAS')
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Poppins", sans-serif;
            background: #f5f7fb;
            color: #333;
        }

        /* SIDEBAR */

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #1976ed, #0865d1);
            padding: 30px 15px;
            z-index: 1000;
            color: white;
        }

        .logo {
            padding: 0 15px;
            margin-bottom: 45px;
        }

        .logo h4 {
            color: white;
            font-size: 25px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .logo small {
            color: rgba(255,255,255,0.85);
            font-size: 12px;
        }

        .menu-title {
            font-size: 11px;
            color: rgba(255,255,255,0.65);
            font-weight: 600;
            padding: 0 10px;
            margin: 20px 0 10px;
            text-transform: uppercase;
        }

        .menu {
            list-style: none;
            padding: 0;
        }

        .menu li {
            margin-bottom: 5px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 10px;
            border-radius: 9px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            transition: 0.2s;
        }

        .menu a i {
            width: 20px;
            text-align: center;
        }

        .menu a:hover {
            background: rgba(255,255,255,0.15);
            color: white;
        }

        .menu a.active {
            background: rgba(255,255,255,0.18);
            color: white;
        }

        /* LOGOUT */

        .logout-area {
            position: absolute;
            bottom: 25px;
            left: 15px;
            right: 15px;
        }

        .logout-btn {
            width: 100%;
            border: none;
            background: rgba(255,255,255,0.15);
            color: white;
            padding: 11px;
            border-radius: 9px;
            font-size: 14px;
            cursor: pointer;
            text-align: left;
        }

        .logout-btn:hover {
            background: rgba(255,255,255,0.25);
        }

        /* CONTENT */

        .main-content {
            margin-left: 250px;
            padding: 30px;
            min-height: 100vh;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .page-title {
            font-size: 25px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .page-subtitle {
            color: #888;
            font-size: 14px;
        }

        .date-box {
            background: white;
            padding: 10px 16px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            color: #555;
            font-size: 13px;
        }

        /* CARDS */

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .card-custom {
            background: white;
            border-radius: 15px;
            padding: 25px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 3px 10px rgba(0,0,0,0.03);
        }

        .stat-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-title {
            font-size: 12px;
            font-weight: 600;
            color: #888;
            margin-bottom: 8px;
        }

        .stat-number {
            font-size: 26px;
            font-weight: 700;
            color: #222;
            margin-bottom: 5px;
        }

        .stat-desc {
            color: #888;
            font-size: 12px;
        }

        .green-text {
            color: #16a34a !important;
        }

        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .icon-box.blue {
            background: #eff6ff;
            color: #2563eb;
        }

        .icon-box.green {
            background: #ecfdf5;
            color: #16a34a;
        }

        .icon-box.yellow {
            background: #fffbeb;
            color: #eab308;
        }

        /* DASHBOARD GRID */

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 7px;
        }

        .section-subtitle {
            color: #888;
            font-size: 13px;
        }

        /* BUTTON */

        .btn-primary-custom {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #2563eb;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-primary-custom:hover {
            background: #1d4ed8;
            color: white;
        }

        .btn-success-custom {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #16a34a;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-success-custom:hover {
            background: #15803d;
            color: white;
        }

        /* TABLE */

        table {
            background: white;
        }

        /* ALERT */

        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }

        /* MOBILE */

        @media (max-width: 900px) {

            .cards {
                grid-template-columns: 1fr;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }

        }

        @media (max-width: 768px) {

            .sidebar {
                width: 70px;
                padding: 25px 10px;
            }

            .logo h4 {
                font-size: 0;
            }

            .logo h4::after {
                content: "SI";
                font-size: 20px;
            }

            .logo small,
            .menu-title,
            .menu a span {
                display: none;
            }

            .logo {
                text-align: center;
                padding: 0;
            }

            .menu a {
                justify-content: center;
                padding: 12px;
            }

            .logout-area {
                left: 10px;
                right: 10px;
            }

            .logout-btn {
                text-align: center;
            }

            .logout-btn span {
                display: none;
            }

            .main-content {
                margin-left: 70px;
                padding: 20px;
            }

        }

    </style>

    @stack('styles')

</head>

<body>

    {{-- SIDEBAR PENGURUS --}}

    <aside class="sidebar">

        <div class="logo">

            <h4>SIKAS</h4>

            <small>
                Sistem Kas Warga
            </small>

        </div>


        {{-- MENU --}}

        <div class="menu-title">
            Menu
        </div>

        <ul class="menu">

            {{-- DASHBOARD --}}

            <li>

                <a
                    href="{{ route('pengurus.dashboard') }}"
                    class="{{ request()->routeIs('pengurus.dashboard') ? 'active' : '' }}"
                >

                    <i class="fa-solid fa-house"></i>

                    <span>
                        Dashboard
                    </span>

                </a>

            </li>

        </ul>


        {{-- TRANSAKSI --}}

        <div class="menu-title">
            Transaksi
        </div>

        <ul class="menu">

            {{-- INPUT PEMBAYARAN --}}

            <li>

                <a
                    href="{{ route('pengurus.pembayaran.create') }}"
                    class="{{ request()->routeIs('pengurus.pembayaran.create') ? 'active' : '' }}"
                >

                    <i class="fa-regular fa-credit-card"></i>

                    <span>
                        Input Pembayaran
                    </span>

                </a>

            </li>


            {{-- RIWAYAT PEMBAYARAN --}}

            <li>

                <a
                    href="{{ route('pengurus.pembayaran.index') }}"
                    class="{{ request()->routeIs('pengurus.pembayaran.index') ? 'active' : '' }}"
                >

                    <i class="fa-regular fa-calendar-check"></i>

                    <span>
                        Riwayat Pembayaran
                    </span>

                </a>

            </li>


            {{-- PEMASUKAN --}}

            <li>

                <a
                    href="{{ route('pengurus.pemasukan.index') }}"
                    class="{{ request()->routeIs('pengurus.pemasukan.*') ? 'active' : '' }}"
                >

                    <i class="fa-solid fa-money-bill-transfer"></i>

                    <span>
                        Pemasukan
                    </span>

                </a>

            </li>


            {{-- PENGELUARAN --}}

            <li>

                <a
                    href="{{ route('pengurus.pengeluaran.index') }}"
                    class="{{ request()->routeIs('pengurus.pengeluaran.*') ? 'active' : '' }}"
                >

                    <i class="fa-solid fa-wallet"></i>

                    <span>
                        Pengeluaran
                    </span>

                </a>

            </li>

        </ul>


        {{-- INFORMASI --}}

        <div class="menu-title">
            Informasi
        </div>

        <ul class="menu">

            {{-- PENGUMUMAN --}}

            <li>

                <a
                    href="{{ route('pengurus.pengumuman.index') }}"
                    class="{{ request()->routeIs('pengurus.pengumuman.*') ? 'active' : '' }}"
                >

                    <i class="fa-solid fa-bullhorn"></i>

                    <span>
                        Pengumuman
                    </span>

                </a>

            </li>


            {{-- DATA WARGA --}}

            <li>

                <a
                    href="{{ route('pengurus.warga.index') }}"
                    class="{{ request()->routeIs('pengurus.warga.*') ? 'active' : '' }}"
                >

                    <i class="fa-solid fa-users"></i>

                    <span>
                        Data Warga
                    </span>

                </a>

            </li>


            {{-- LAPORAN --}}

            <li>

                <a
                    href="{{ route('pengurus.laporan') }}"
                    class="{{ request()->routeIs('pengurus.laporan*') ? 'active' : '' }}"
                >

                    <i class="fa-solid fa-file-lines"></i>

                    <span>
                        Laporan
                    </span>

                </a>

            </li>

        </ul>


        {{-- AKUN --}}

        <div class="menu-title">
            Akun
        </div>

        <ul class="menu">

            {{-- PROFIL --}}

            <li>

                <a
                    href="{{ route('pengurus.profil') }}"
                    class="{{ request()->routeIs('pengurus.profil') ? 'active' : '' }}"
                >

                    <i class="fa-solid fa-user"></i>

                    <span>
                        Profil
                    </span>

                </a>

            </li>

        </ul>


        {{-- LOGOUT --}}

        <div class="logout-area">

            <form
                action="{{ route('pengurus.logout') }}"
                method="POST"
            >

                @csrf

                <button
                    type="submit"
                    class="logout-btn"
                >

                    <i class="fa-solid fa-right-from-bracket"></i>

                    <span>
                        Logout
                    </span>

                </button>

            </form>

        </div>

    </aside>


    {{-- KONTEN --}}

    <main class="main-content">

        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif


        @if(session('error'))

            <div class="alert alert-danger">

                {{ session('error') }}

            </div>

        @endif


        @yield('content')

    </main>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

    @stack('scripts')

</body>

</html>