@extends('layout.warga')

@section('title', 'Pembayaran Iuran | SI-KAS RT')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | DAFTAR BULAN
    |--------------------------------------------------------------------------
    */
    $daftarBulan = [
        'Januari' => 1,
        'Februari' => 2,
        'Maret' => 3,
        'April' => 4,
        'Mei' => 5,
        'Juni' => 6,
        'Juli' => 7,
        'Agustus' => 8,
        'September' => 9,
        'Oktober' => 10,
        'November' => 11,
        'Desember' => 12,
    ];

    /*
    |--------------------------------------------------------------------------
    | TANGGAL MULAI WAJIB IURAN
    |--------------------------------------------------------------------------
    | Kalau tanggal_daftar ada:
    | mulai dari bulan warga didaftarkan.
    |
    | Kalau belum ada:
    | sementara mulai dari bulan sekarang supaya warga lama
    | tidak tiba-tiba mendapatkan tunggakan bulan-bulan sebelumnya.
    |--------------------------------------------------------------------------
    */
    if ($warga->tanggal_daftar) {
        $tanggalMulai = \Carbon\Carbon::parse($warga->tanggal_daftar)
            ->startOfMonth();
    } else {
        $tanggalMulai = now()->startOfMonth();
    }

    $tanggalSekarang = now()->startOfMonth();

    /*
    |--------------------------------------------------------------------------
    | AMBIL SEMUA KAS
    |--------------------------------------------------------------------------
    */
    $semuaKas = \App\Models\KasBulanan::orderBy('tahun', 'asc')
        ->orderBy('id', 'asc')
        ->get();

    $daftarKas = collect();

    /*
    |--------------------------------------------------------------------------
    | HITUNG IURAN
    |--------------------------------------------------------------------------
    */
    foreach ($semuaKas as $kas) {

        $nomorBulanKas = $daftarBulan[$kas->bulan] ?? 0;

        if ($nomorBulanKas == 0) {
            continue;
        }

        /*
        |--------------------------------------------------------------------------
        | BUAT TANGGAL KAS
        |--------------------------------------------------------------------------
        */
        try {

            $tanggalKas = \Carbon\Carbon::create(
                (int) $kas->tahun,
                (int) $nomorBulanKas,
                1
            )->startOfMonth();

        } catch (\Throwable $e) {

            continue;
        }

        /*
        |--------------------------------------------------------------------------
        | JANGAN TAMPILKAN IURAN SEBELUM BULAN PENDAFTARAN
        |--------------------------------------------------------------------------
        */
        if ($tanggalKas->lt($tanggalMulai)) {
            continue;
        }

        /*
        |--------------------------------------------------------------------------
        | JANGAN TAMPILKAN IURAN BULAN YANG BELUM BERJALAN
        |--------------------------------------------------------------------------
        */
        if ($tanggalKas->gt($tanggalSekarang)) {
            continue;
        }

        /*
        |--------------------------------------------------------------------------
        | HITUNG TOTAL PEMBAYARAN WARGA
        |--------------------------------------------------------------------------
        */
        $totalBayar = \App\Models\Pembayaran::where(
                'kas_bulanan_id',
                $kas->id
            )
            ->where(function ($query) use ($warga) {

                $query->where('warga_id', $warga->id)
                    ->orWhere('no_kk', $warga->no_kk);

            })
            ->whereIn('status', [
                'Lunas',
                'Cicilan',
                'Menunggu Verifikasi',
                'Menunggu Konfirmasi',
            ])
            ->sum('jumlah');

        /*
        |--------------------------------------------------------------------------
        | HITUNG SISA
        |--------------------------------------------------------------------------
        */
        $nominalKas = (float) $kas->nominal;

        $sisaBayar = max(
            0,
            $nominalKas - (float) $totalBayar
        );

        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */
        if ($totalBayar >= $nominalKas) {

            $statusBayar = 'Lunas';

        } elseif ($totalBayar > 0) {

            $statusBayar = 'Cicilan';

        } else {

            $statusBayar = 'Belum Bayar';

        }

        /*
        |--------------------------------------------------------------------------
        | MASUKKAN KE DAFTAR
        |--------------------------------------------------------------------------
        */
        $daftarKas->push([
            'kas' => $kas,
            'nomor_bulan' => $nomorBulanKas,
            'total_bayar' => $totalBayar,
            'sisa_bayar' => $sisaBayar,
            'status' => $statusBayar,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | URUTKAN DARI BULAN TERLAMA KE TERBARU
    |--------------------------------------------------------------------------
    */
    $daftarKas = $daftarKas
        ->sortBy(function ($item) {

            return ($item['kas']->tahun * 100)
                + $item['nomor_bulan'];

        })
        ->values();

    /*
    |--------------------------------------------------------------------------
    | YANG BELUM LUNAS
    |--------------------------------------------------------------------------
    */
    $kasBelumLunas = $daftarKas
        ->filter(function ($item) {

            return $item['sisa_bayar'] > 0;

        })
        ->values();

    /*
    |--------------------------------------------------------------------------
    | TOTAL TUNGGAKAN
    |--------------------------------------------------------------------------
    */
    $totalTunggakan = $kasBelumLunas->sum('sisa_bayar');

    /*
    |--------------------------------------------------------------------------
    | YANG SUDAH LUNAS
    |--------------------------------------------------------------------------
    */
    $kasLunas = $daftarKas
        ->filter(function ($item) {

            return $item['status'] === 'Lunas';

        })
        ->values();

@endphp


<style>

    .payment-card {
        border-radius: 10px;
        overflow: hidden;
    }

    .payment-card .card-header {
        padding: 20px 24px 16px;
    }

    .payment-card .card-body {
        padding: 20px 24px;
    }

    .info-item {
        padding: 12px 15px;
        background: #f8f9fa;
        border-radius: 8px;
        height: 100%;
    }

    .table thead th {
        background: #f8f9fa;
        white-space: nowrap;
        font-size: 14px;
        padding: 13px 12px;
    }

    .table tbody td {
        padding: 13px 12px;
        font-size: 14px;
    }

    .payment-form-box {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 18px;
    }

    .lunas-card {
        border-radius: 8px;
        background: #f8f9fa;
        height: 100%;
    }

    .lunas-card .card-content {
        padding: 15px;
    }

    .form-label {
        margin-bottom: 7px;
    }

    .alert {
        border-radius: 10px;
    }

</style>


<div class="container-fluid py-4">

    {{-- JUDUL --}}
    <div class="mb-4">

        <h3 class="fw-bold mb-1">

            <i class="bi bi-wallet2 me-2"></i>

            Pembayaran Iuran

        </h3>

        <p class="text-muted mb-0">

            Kelola pembayaran iuran kas Warga Anda.

        </p>

    </div>


    {{-- DATA WARGA --}}
    <div class="card border-0 shadow-sm payment-card mb-4">

        <div class="card-header bg-white border-0">

            <h5 class="fw-bold mb-1">

                <i class="bi bi-person-circle me-2"></i>

                Data Warga

            </h5>

            <small class="text-muted">

                Informasi data warga yang sedang login.

            </small>

        </div>


        <div class="card-body">

            <div class="row g-3">

                {{-- NAMA --}}
                <div class="col-md-4">

                    <div class="info-item">

                        <small class="text-muted d-block mb-1">

                            Nama

                        </small>

                        <div class="fw-semibold">

                            {{ $warga->nama ?? '-' }}

                        </div>

                    </div>

                </div>


                {{-- NO KK --}}
                <div class="col-md-4">

                    <div class="info-item">

                        <small class="text-muted d-block mb-1">

                            Nomor KK

                        </small>

                        <div class="fw-semibold">

                            {{ $warga->no_kk ?? '-' }}

                        </div>

                    </div>

                </div>


                {{-- STATUS --}}
                <div class="col-md-4">

                    <div class="info-item">

                        <small class="text-muted d-block mb-1">

                            Status

                        </small>

                        <div>

                            @if(($warga->status ?? '') === 'Aktif')

                                <span class="badge bg-success">

                                    Aktif

                                </span>

                            @else

                                <span class="badge bg-secondary">

                                    {{ $warga->status ?? '-' }}

                                </span>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- TANGGAL DAFTAR --}}
                @if($warga->tanggal_daftar)

                    <div class="col-md-4">

                        <div class="info-item">

                            <small class="text-muted d-block mb-1">

                                Terdaftar Sejak

                            </small>

                            <div class="fw-semibold">

                                {{ \Carbon\Carbon::parse($warga->tanggal_daftar)->translatedFormat('d F Y') }}

                            </div>

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- INFO MULAI WAJIB IURAN --}}
    @if($warga->tanggal_daftar)

        <div class="alert alert-info border-0 shadow-sm mb-4">

            <div class="d-flex align-items-center">

                <div class="me-3">

                    <i class="bi bi-info-circle-fill fs-2"></i>

                </div>

                <div>

                    <h6 class="fw-bold mb-1">

                        Mulai wajib iuran

                    </h6>

                    <div>

                        Anda mulai memiliki kewajiban iuran sejak

                        <strong>

                            {{ \Carbon\Carbon::parse($warga->tanggal_daftar)->translatedFormat('F Y') }}

                        </strong>.

                        Iuran sebelum bulan tersebut tidak perlu dibayar.

                    </div>

                </div>

            </div>

        </div>

    @endif


    {{-- TOTAL SISA --}}
    @if($totalTunggakan > 0)

        <div class="alert alert-warning border-0 shadow-sm mb-4">

            <div class="d-flex align-items-center">

                <div class="me-3">

                    <i class="bi bi-exclamation-triangle-fill fs-2"></i>

                </div>

                <div>

                    <h6 class="fw-bold mb-1">

                        Anda memiliki tagihan

                    </h6>

                    <div>

                        Total sisa pembayaran:

                        <strong>

                            Rp {{ number_format($totalTunggakan, 0, ',', '.') }}

                        </strong>

                    </div>

                </div>

            </div>

        </div>

    @endif


    {{-- DAFTAR IURAN --}}
    <div class="card border-0 shadow-sm payment-card mb-4">

        <div class="card-header bg-white border-0">

            <h5 class="fw-bold mb-1">

                <i class="bi bi-calendar-check me-2"></i>

                Daftar Iuran

            </h5>

            <small class="text-muted">

                Berikut seluruh tagihan iuran Anda sejak terdaftar.

            </small>

        </div>


        <div class="card-body">

            @if($daftarKas->count() > 0)

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>

                            <tr>

                                <th>Bulan</th>

                                <th>Tahun</th>

                                <th>Nominal</th>

                                <th>Sudah Dibayar</th>

                                <th>Sisa</th>

                                <th>Status</th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($daftarKas as $item)

                                @php

                                    $kas = $item['kas'];

                                @endphp

                                <tr>

                                    <td class="fw-semibold">

                                        {{ $kas->bulan }}

                                    </td>

                                    <td>

                                        {{ $kas->tahun }}

                                    </td>

                                    <td>

                                        Rp {{ number_format($kas->nominal, 0, ',', '.') }}

                                    </td>

                                    <td>

                                        Rp {{ number_format($item['total_bayar'], 0, ',', '.') }}

                                    </td>

                                    <td>

                                        <strong>

                                            Rp {{ number_format($item['sisa_bayar'], 0, ',', '.') }}

                                        </strong>

                                    </td>

                                    <td>

                                        @if($item['status'] === 'Lunas')

                                            <span class="badge bg-success">

                                                <i class="bi bi-check-circle me-1"></i>

                                                Lunas

                                            </span>

                                        @elseif($item['status'] === 'Cicilan')

                                            <span class="badge bg-info">

                                                <i class="bi bi-hourglass-split me-1"></i>

                                                Cicilan

                                            </span>

                                        @else

                                            <span class="badge bg-warning text-dark">

                                                Belum Bayar

                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5">

                    <i class="bi bi-check-circle text-success fs-1"></i>

                    <h5 class="fw-bold mt-3">

                        Tidak ada tagihan

                    </h5>

                    <p class="text-muted mb-0">

                        Saat ini belum ada iuran yang perlu dibayarkan.

                    </p>

                </div>

            @endif

        </div>

    </div>


    {{-- FORM PEMBAYARAN --}}
    @if($kasBelumLunas->count() > 0)

        <div class="card border-0 shadow-sm payment-card mb-4">

            <div class="card-header bg-white border-0">

                <h5 class="fw-bold mb-1">

                    <i class="bi bi-credit-card me-2"></i>

                    Bayar Iuran

                </h5>

                <small class="text-muted">

                    Pembayaran hanya melalui transfer dan dapat dilakukan secara cicilan.

                </small>

            </div>


            <div class="card-body">

                <div class="payment-form-box">

                    <form action="{{ route('warga.pembayaran.store') }}"

                          method="POST"

                          enctype="multipart/form-data"

                          id="formPembayaran">

                        @csrf


                        {{-- PILIH BULAN --}}
                        <div class="mb-4">

                            <label for="kas_bulanan_id"

                                   class="form-label fw-semibold">

                                Pilih Bulan

                            </label>


                            <select name="kas_bulanan_id"

                                    id="kas_bulanan_id"

                                    class="form-select"

                                    required>

                                <option value="">

                                    -- Pilih bulan yang ingin dibayar --

                                </option>


                                @foreach($kasBelumLunas as $item)

                                    @php

                                        $kas = $item['kas'];

                                    @endphp

                                    <option value="{{ $kas->id }}"

                                            data-sisa="{{ $item['sisa_bayar'] }}">

                                        {{ $kas->bulan }} {{ $kas->tahun }}

                                        -

                                        Sisa Rp

                                        {{ number_format($item['sisa_bayar'], 0, ',', '.') }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- JUMLAH --}}
                        <div class="mb-4">

                            <label for="jumlah"

                                   class="form-label fw-semibold">

                                Jumlah Pembayaran

                            </label>


                            <div class="input-group">

                                <span class="input-group-text">

                                    Rp

                                </span>


                                <input type="number"

                                       name="jumlah"

                                       id="jumlah"

                                       class="form-control"

                                       min="1000"

                                       step="1000"

                                       placeholder="Contoh: 5000"

                                       required>

                            </div>


                            <small class="text-muted"

                                   id="infoSisa">

                                Pilih bulan terlebih dahulu.

                            </small>

                        </div>


                        {{-- METODE --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">

                                Metode Pembayaran

                            </label>


                            <div class="form-check border rounded p-3 bg-white">

                                <input type="radio"

                                       name="metode_pembayaran"

                                       id="transfer"

                                       value="Transfer"

                                       class="form-check-input"

                                       checked

                                       required>


                                <label for="transfer"

                                       class="form-check-label">

                                    <i class="bi bi-bank me-2"></i>

                                    <strong>

                                        Transfer

                                    </strong>


                                    <div class="small text-muted mt-1">

                                        Pembayaran dilakukan melalui transfer.

                                    </div>

                                </label>

                            </div>

                        </div>


                        {{-- BUKTI TRANSFER --}}
                        <div class="mb-4">

                            <label for="bukti_pembayaran"

                                   class="form-label fw-semibold">

                                Bukti Transfer

                            </label>


                            <input type="file"

                                   name="bukti_pembayaran"

                                   id="bukti_pembayaran"

                                   class="form-control"

                                   accept="image/*"

                                   required>


                            <small class="text-muted">

                                Upload screenshot atau foto bukti transfer.

                            </small>

                        </div>


                        {{-- INFO PEMBAYARAN --}}
                        <div id="infoPembayaran"

                             class="alert alert-info"

                             style="display: none;">

                            <i class="bi bi-info-circle me-2"></i>

                            <span id="textInfoPembayaran"></span>

                        </div>


                        {{-- BUTTON --}}
                        <div class="d-flex justify-content-end">

                            <button type="submit"

                                    class="btn btn-primary px-4"

                                    id="btnBayar">

                                <i class="bi bi-send me-2"></i>

                                Kirim Pembayaran

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    @endif


    {{-- IURAN LUNAS --}}
    @if($kasLunas->count() > 0)

        <div class="card border-0 shadow-sm payment-card mb-4">

            <div class="card-header bg-white border-0">

                <h5 class="fw-bold mb-1">

                    <i class="bi bi-check-circle-fill text-success me-2"></i>

                    Iuran Lunas

                </h5>


                <small class="text-muted">

                    Riwayat iuran yang sudah lunas.

                </small>

            </div>


            <div class="card-body">

                <div class="row g-3">

                    @foreach($kasLunas as $item)

                        @php

                            $kas = $item['kas'];

                        @endphp


                        <div class="col-md-4">

                            <div class="lunas-card">

                                <div class="card-content">

                                    <div class="d-flex justify-content-between align-items-center">

                                        <div>

                                            <div class="fw-bold">

                                                {{ $kas->bulan }} {{ $kas->tahun }}

                                            </div>


                                            <small class="text-muted">

                                                Rp {{ number_format($kas->nominal, 0, ',', '.') }}

                                            </small>

                                        </div>


                                        <span class="badge bg-success">

                                            <i class="bi bi-check-circle me-1"></i>

                                            Lunas

                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    @endif

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const selectKas =
        document.getElementById('kas_bulanan_id');

    const inputJumlah =
        document.getElementById('jumlah');

    const infoSisa =
        document.getElementById('infoSisa');

    const infoPembayaran =
        document.getElementById('infoPembayaran');

    const textInfoPembayaran =
        document.getElementById('textInfoPembayaran');

    const buktiPembayaran =
        document.getElementById('bukti_pembayaran');

    const form =
        document.getElementById('formPembayaran');


    function formatRupiah(angka) {

        return new Intl.NumberFormat('id-ID')
            .format(angka);

    }


    function updatePembayaran() {

        if (!selectKas || !inputJumlah) {

            return;

        }


        const option =
            selectKas.options[
                selectKas.selectedIndex
            ];


        const sisa =
            parseFloat(
                option?.dataset?.sisa || 0
            );


        let jumlah =
            parseFloat(
                inputJumlah.value || 0
            );


        if (!sisa) {

            infoSisa.innerHTML =
                'Pilih bulan terlebih dahulu.';

            if (infoPembayaran) {

                infoPembayaran.style.display =
                    'none';

            }

            return;

        }


        inputJumlah.max = sisa;


        if (jumlah > sisa) {

            jumlah = sisa;

            inputJumlah.value = sisa;

        }


        infoSisa.innerHTML =
            'Sisa pembayaran: <strong>Rp ' +
            formatRupiah(sisa) +
            '</strong>';


        if (!jumlah || jumlah <= 0) {

            if (infoPembayaran) {

                infoPembayaran.style.display =
                    'none';

            }

            return;

        }


        if (infoPembayaran) {

            infoPembayaran.style.display =
                'block';

        }


        if (jumlah >= sisa) {

            textInfoPembayaran.innerHTML =
                '<strong>Pembayaran penuh.</strong> ' +
                'Jika pembayaran disetujui, iuran akan menjadi Lunas.';

        } else {

            const sisaSetelahBayar =
                sisa - jumlah;


            textInfoPembayaran.innerHTML =
                '<strong>Pembayaran cicilan.</strong> ' +
                'Sisa tagihan setelah pembayaran ini: ' +
                '<strong>Rp ' +
                formatRupiah(sisaSetelahBayar) +
                '</strong>.';

        }

    }


    if (selectKas) {

        selectKas.addEventListener(
            'change',
            function () {

                inputJumlah.value = '';

                updatePembayaran();

            }
        );

    }


    if (inputJumlah) {

        inputJumlah.addEventListener(
            'input',
            updatePembayaran
        );

    }


    if (form) {

        form.addEventListener(
            'submit',
            function (event) {

                const option =
                    selectKas.options[
                        selectKas.selectedIndex
                    ];


                const sisa =
                    parseFloat(
                        option?.dataset?.sisa || 0
                    );


                const jumlah =
                    parseFloat(
                        inputJumlah.value || 0
                    );


                if (!selectKas.value) {

                    event.preventDefault();

                    alert(
                        'Silakan pilih bulan yang ingin dibayar.'
                    );

                    return;

                }


                if (!jumlah || jumlah <= 0) {

                    event.preventDefault();

                    alert(
                        'Jumlah pembayaran harus lebih dari 0.'
                    );

                    return;

                }


                if (jumlah > sisa) {

                    event.preventDefault();

                    alert(
                        'Jumlah pembayaran tidak boleh lebih besar dari sisa tagihan.'
                    );

                    return;

                }


                if (
                    !buktiPembayaran ||
                    !buktiPembayaran.files.length
                ) {

                    event.preventDefault();

                    alert(
                        'Silakan upload bukti transfer terlebih dahulu.'
                    );

                    return;

                }

            }
        );

    }

});

</script>

@endsection