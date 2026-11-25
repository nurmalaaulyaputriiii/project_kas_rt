@extends('layout.app')

@section('title', 'Dashboard | SI-KAS RT')

@section('content')

<div class="topbar">
    <div>
        <h1 class="page-title">Dashboard Admin</h1>
        <div class="page-subtitle">
            Selamat datang kembali, Admin 👋
        </div>
    </div>

    <div class="date-box">
        <i class="fa-regular fa-calendar"></i>
        {{ now()->translatedFormat('F Y') }}
    </div>
</div>

<div class="cards">

    <div class="card-custom stat-card">
        <div>
            <div class="stat-title">DATA WARGA</div>

            <div class="stat-number">
                {{ $jumlahWarga }}
            </div>

            <div class="stat-desc">
                Warga terdaftar
            </div>
        </div>

        <div class="icon-box blue">
            <i class="fa-solid fa-users"></i>
        </div>
    </div>

    <div class="card-custom stat-card">
        <div>
            <div class="stat-title">TOTAL KAS</div>

            <div class="stat-number">
                Rp {{ number_format($saldo, 0, ',', '.') }}
            </div>

            <div class="stat-desc green-text">
                <i class="fa-solid fa-wallet"></i>
                Saldo kas
            </div>
        </div>

        <div class="icon-box green">
            <i class="fa-solid fa-wallet"></i>
        </div>
    </div>

    <div class="card-custom stat-card">
        <div>
            <div class="stat-title">IURAN BULAN INI</div>

            <div class="stat-number">
                Rp {{ number_format($iuranBulanan, 0, ',', '.') }}
            </div>

            <div class="stat-desc" style="color:#efa900">
                <i class="fa-solid fa-calendar-check"></i>
                Per KK / bulan
            </div>
        </div>

        <div class="icon-box yellow">
            <i class="fa-solid fa-calendar-check"></i>
        </div>
    </div>

</div>

<div class="dashboard-grid">

    <div class="card-custom">

        <div class="section-title">
            Grafik Keuangan
        </div>

        <div class="section-subtitle">
            Kas masuk dan pengeluaran
        </div>

        <canvas id="financeChart"></canvas>

    </div>

    <div class="card-custom">

        <div class="section-title">
            Ringkasan Kas
        </div>

        <div class="section-subtitle">
            {{ now()->translatedFormat('F Y') }}
        </div>

        <div class="summary-item">
            <div class="summary-label">
                <i class="fa-regular fa-circle-down"></i>
                Kas Masuk
            </div>

            <div class="summary-value green-text">
                Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}
            </div>
        </div>

        <div class="summary-item">
            <div class="summary-label">
                <i class="fa-regular fa-circle-up"></i>
                Pengeluaran
            </div>

            <div class="summary-value red-text">
                Rp {{ number_format($pengeluaranBulanIni, 0, ',', '.') }}
            </div>
        </div>

        <hr>

        <div class="summary-item">
            <div class="summary-label">
                Saldo Bersih
            </div>

            <div class="summary-value">
                Rp {{ number_format($saldoBulanIni, 0, ',', '.') }}
            </div>
        </div>

    </div>

</div>

@endsection

@section('script')

<script>

const ctx = document.getElementById('financeChart');

new Chart(ctx, {

    type: 'line',

    data: {
        labels: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'
        ],

        datasets: [
            {
                label: 'Kas Masuk',
                data: @json($grafikPemasukan),
                borderWidth: 3,
                tension: .4
            },
            {
                label: 'Pengeluaran',
                data: @json($grafikPengeluaran),
                borderWidth: 3,
                tension: .4
            }
        ]
    },

    options: {
        responsive: true,

        plugins: {
            legend: {
                position: 'top'
            }
        },

        scales: {
            y: {
                beginAtZero: true,

                ticks: {
                    callback: function(value) {
                        return 'Rp ' +
                            new Intl.NumberFormat('id-ID').format(value);
                    }
                }
            }
        }
    }

});

</script>

@endsection