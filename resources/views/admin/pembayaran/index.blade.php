@extends('layout.app')

@section('title', 'Pembayaran Iuran | SI-KAS RT')

@section('content')

<style>
    .table-card {
        background: #fff;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, .06);
    }

    .section-title {
        font-size: 22px;
        font-weight: 700;
        color: #172b4d;
    }

    .section-subtitle {
        color: #6b7280;
        font-size: 14px;
    }

    .table th {
        white-space: nowrap;
        color: #475569;
        font-size: 14px;
        font-weight: 700;
    }

    .table td {
        vertical-align: middle;
        font-size: 14px;
    }

    .status-verifier {
        line-height: 1.4;
        min-width: 150px;
    }

    .verifier-name {
        font-weight: 600;
        color: #334155;
    }

    .verifier-role {
        font-size: 12px;
        color: #64748b;
    }

    .waiting-text {
        font-size: 12px;
        color: #dc2626;
        margin-top: 6px;
    }

    .method-transfer {
        color: #0d6efd;
        font-weight: 600;
        white-space: nowrap;
    }

    .method-tunai {
        color: #198754;
        font-weight: 600;
        white-space: nowrap;
    }

    .modal-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
    }

    .modal-header {
        padding: 20px 24px;
    }

    .modal-body {
        padding: 24px;
    }

    .modal-footer {
        padding: 18px 24px;
    }

    #infoPembayaran {
        border-radius: 12px;
    }

    @media (max-width: 768px) {
        .table-card {
            padding: 18px;
        }

        .topbar {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 15px;
        }

        .topbar > div:last-child {
            width: 100%;
        }

        .topbar .btn {
            width: 100%;
        }
    }
</style>


{{-- ========================================================= --}}
{{-- TOPBAR --}}
{{-- ========================================================= --}}

<div class="topbar">

    <div>
        <h1 class="page-title">
            Pembayaran Iuran
        </h1>

        <div class="page-subtitle">
            Verifikasi pembayaran warga
        </div>
    </div>


    {{-- TOMBOL INPUT TUNAI --}}
    <div>

        <button
            type="button"
            class="btn btn-success"
            data-bs-toggle="modal"
            data-bs-target="#modalPembayaranTunai"
        >

            <i class="fa-solid fa-money-bill-wave me-2"></i>

            Input Pembayaran Tunai

        </button>

    </div>

</div>


{{-- ========================================================= --}}
{{-- PESAN SUCCESS --}}
{{-- ========================================================= --}}

@if(session('success'))

    <div class="alert alert-success">

        <i class="fa-solid fa-circle-check me-2"></i>

        {{ session('success') }}

    </div>

@endif


{{-- ========================================================= --}}
{{-- PESAN ERROR --}}
{{-- ========================================================= --}}

@if(session('error'))

    <div class="alert alert-danger">

        <i class="fa-solid fa-circle-exclamation me-2"></i>

        {{ session('error') }}

    </div>

@endif


@if($errors->any())

    <div class="alert alert-danger">

        <i class="fa-solid fa-circle-exclamation me-2"></i>

        {{ $errors->first() }}

    </div>

@endif


{{-- ========================================================= --}}
{{-- TABEL PEMBAYARAN --}}
{{-- ========================================================= --}}

<div class="table-card">

    <div class="mb-4">

        <h2 class="section-title mb-1">
            Daftar Pembayaran
        </h2>

        <div class="section-subtitle">
            Periksa dan verifikasi pembayaran iuran warga
        </div>

    </div>


    <div class="table-responsive">

        <table class="table align-middle">

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

                @forelse($pembayaran as $item)

                    <tr>

                        {{-- ================================================= --}}
                        {{-- NO --}}
                        {{-- ================================================= --}}

                        <td>
                            {{ $loop->iteration }}
                        </td>


                        {{-- ================================================= --}}
                        {{-- WARGA --}}
                        {{-- ================================================= --}}

                        <td>

                            <div class="fw-semibold">
                                {{ $item->warga->nama ?? '-' }}
                            </div>

                            <small class="text-muted">

                                KK:

                                {{ $item->no_kk ?? ($item->warga->no_kk ?? '-') }}

                            </small>

                        </td>


                        {{-- ================================================= --}}
                        {{-- IURAN --}}
                        {{-- ================================================= --}}

                        <td>

                            @if($item->kasBulanan)

                                <div class="fw-semibold">
                                    {{ $item->kasBulanan->bulan }}
                                </div>

                                <small class="text-muted">
                                    Tahun {{ $item->kasBulanan->tahun }}
                                </small>

                            @else

                                -

                            @endif

                        </td>


                        {{-- ================================================= --}}
                        {{-- TANGGAL BAYAR --}}
                        {{-- ================================================= --}}

                        <td>

                            @if($item->tanggal_bayar)

                                {{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d/m/Y') }}

                                <br>

                                <small class="text-muted">

                                    {{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('H:i') }}

                                </small>

                            @else

                                -

                            @endif

                        </td>


                        {{-- ================================================= --}}
                        {{-- JUMLAH --}}
                        {{-- ================================================= --}}

                        <td>

                            <span class="fw-bold text-primary">

                                Rp {{ number_format($item->jumlah, 0, ',', '.') }}

                            </span>

                        </td>


                        {{-- ================================================= --}}
                        {{-- JENIS PEMBAYARAN --}}
                        {{-- ================================================= --}}

                        <td>

                            @if(strtolower($item->jenis_pembayaran ?? '') === 'lunas')

                                <span class="badge bg-success">
                                    Lunas
                                </span>

                            @elseif(strtolower($item->jenis_pembayaran ?? '') === 'cicilan')

                                <span class="badge bg-warning text-dark">
                                    Cicilan
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    -
                                </span>

                            @endif

                        </td>


                        {{-- ================================================= --}}
                        {{-- METODE PEMBAYARAN --}}
                        {{-- ================================================= --}}

                        <td>

                            @if(strtolower($item->metode_pembayaran ?? '') === 'transfer')

                                <span class="method-transfer">

                                    <i class="fa-solid fa-building-columns me-1"></i>

                                    Transfer

                                </span>

                            @elseif(strtolower($item->metode_pembayaran ?? '') === 'tunai')

                                <span class="method-tunai">

                                    <i class="fa-solid fa-money-bill-wave me-1"></i>

                                    Tunai

                                </span>

                            @else

                                -

                            @endif

                        </td>


                        {{-- ================================================= --}}
                        {{-- STATUS + VERIFIKATOR --}}
                        {{-- ================================================= --}}

                        <td>

                            {{-- ============================= --}}
                            {{-- LUNAS --}}
                            {{-- ============================= --}}

                            @if($item->status === 'Lunas')

                                <span class="badge rounded-pill bg-success">

                                    <i class="fa-solid fa-circle-check me-1"></i>

                                    Lunas

                                </span>


                                @if($item->verified_by_name)

                                    <div class="status-verifier mt-2">

                                        <div class="verifier-name">

                                            <i class="fa-solid fa-user-check me-1"></i>

                                            {{ $item->verified_by_name }}

                                        </div>

                                        @if($item->verified_by_role)

                                            <div class="verifier-role">

                                                Diverifikasi sebagai
                                                {{ $item->verified_by_role }}

                                            </div>

                                        @endif

                                    </div>

                                @elseif(strtolower($item->metode_pembayaran ?? '') === 'tunai')

                                    <div class="status-verifier mt-2">

                                        <div class="verifier-name">

                                            <i class="fa-solid fa-user-check me-1"></i>

                                            Input Tunai

                                        </div>

                                        <div class="verifier-role">

                                            Pembayaran tunai

                                        </div>

                                    </div>

                                @endif


                            {{-- ============================= --}}
                            {{-- CICILAN --}}
                            {{-- ============================= --}}

                            @elseif($item->status === 'Cicilan')

                                <span class="badge rounded-pill bg-warning text-dark">

                                    <i class="fa-solid fa-clock me-1"></i>

                                    Cicilan

                                </span>


                                @if($item->verified_by_name)

                                    <div class="status-verifier mt-2">

                                        <div class="verifier-name">

                                            <i class="fa-solid fa-user-check me-1"></i>

                                            {{ $item->verified_by_name }}

                                        </div>

                                        @if($item->verified_by_role)

                                            <div class="verifier-role">

                                                Diverifikasi sebagai
                                                {{ $item->verified_by_role }}

                                            </div>

                                        @endif

                                    </div>

                                @elseif(strtolower($item->metode_pembayaran ?? '') === 'tunai')

                                    <div class="status-verifier mt-2">

                                        <div class="verifier-name">

                                            <i class="fa-solid fa-user-check me-1"></i>

                                            Input Tunai

                                        </div>

                                        <div class="verifier-role">

                                            Pembayaran tunai

                                        </div>

                                    </div>

                                @endif


                            {{-- ============================= --}}
                            {{-- MENUNGGU VERIFIKASI --}}
                            {{-- ============================= --}}

                            @elseif($item->status === 'Menunggu Verifikasi')

                                <span class="badge rounded-pill bg-warning text-dark">

                                    <i class="fa-solid fa-hourglass-half me-1"></i>

                                    Menunggu Verifikasi

                                </span>

                                <div class="waiting-text">

                                    <i class="fa-solid fa-user-clock me-1"></i>

                                    Belum diverifikasi

                                </div>


                            {{-- ============================= --}}
                            {{-- MENUNGGU KONFIRMASI --}}
                            {{-- ============================= --}}

                            @elseif($item->status === 'Menunggu Konfirmasi')

                                <span class="badge rounded-pill bg-info text-dark">

                                    <i class="fa-solid fa-hourglass-half me-1"></i>

                                    Menunggu Konfirmasi

                                </span>

                                <div class="waiting-text">

                                    <i class="fa-solid fa-user-clock me-1"></i>

                                    Belum diverifikasi

                                </div>


                            {{-- ============================= --}}
                            {{-- DITOLAK --}}
                            {{-- ============================= --}}

                            @elseif($item->status === 'Ditolak')

                                <span class="badge rounded-pill bg-danger">

                                    <i class="fa-solid fa-circle-xmark me-1"></i>

                                    Ditolak

                                </span>


                                @if($item->verified_by_name)

                                    <div class="status-verifier mt-2">

                                        <div class="verifier-name">

                                            <i class="fa-solid fa-user-xmark me-1"></i>

                                            {{ $item->verified_by_name }}

                                        </div>

                                        @if($item->verified_by_role)

                                            <div class="verifier-role">

                                                Ditolak oleh
                                                {{ $item->verified_by_role }}

                                            </div>

                                        @endif

                                    </div>

                                @endif


                            {{-- ============================= --}}
                            {{-- STATUS LAIN --}}
                            {{-- ============================= --}}

                            @else

                                <span class="badge rounded-pill bg-secondary">

                                    {{ $item->status ?? '-' }}

                                </span>

                            @endif

                        </td>


                        {{-- ================================================= --}}
                        {{-- AKSI --}}
                        {{-- ================================================= --}}

                        <td>

                            @if(
                                $item->status === 'Menunggu Verifikasi' ||
                                $item->status === 'Menunggu Konfirmasi'
                            )

                                <a
                                    href="{{ route('admin.pembayaran.show', $item->id) }}"
                                    class="btn btn-sm btn-primary"
                                >

                                    <i class="fa-solid fa-check me-1"></i>

                                    Verifikasi

                                </a>

                            @else

                                <span class="text-muted small">

                                    <i class="fa-solid fa-circle-check me-1"></i>

                                    Sudah diverifikasi

                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="9"
                            class="text-center py-5"
                        >

                            <i
                                class="fa-solid fa-receipt"
                                style="font-size:40px;color:#94a3b8;"
                            ></i>

                            <div class="mt-3 fw-semibold">

                                Belum ada pembayaran

                            </div>

                            <div class="text-muted">

                                Pembayaran warga akan muncul di sini.

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>



{{-- ========================================================= --}}
{{-- MODAL INPUT PEMBAYARAN TUNAI --}}
{{-- ========================================================= --}}

<div
    class="modal fade"
    id="modalPembayaranTunai"
    tabindex="-1"
    aria-labelledby="modalPembayaranTunaiLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">


            {{-- HEADER --}}

            <div class="modal-header">

                <div>

                    <h5
                        class="modal-title"
                        id="modalPembayaranTunaiLabel"
                    >

                        <i class="fa-solid fa-money-bill-wave me-2"></i>

                        Input Pembayaran Tunai

                    </h5>

                    <small class="text-muted">

                        Admin dapat mencatat pembayaran tunai warga secara langsung.

                    </small>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>



            {{-- FORM --}}

            <form
                action="{{ route('admin.pembayaran.tunai.store') }}"
                method="POST"
            >

                @csrf


                <div class="modal-body">


                    {{-- WARGA --}}

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Warga
                        </label>

                        <select
                            name="warga_id"
                            id="warga_id"
                            class="form-select"
                            required
                        >

                            <option value="">
                                -- Pilih Warga --
                            </option>

                            @foreach($warga as $w)

                                <option value="{{ $w->id }}">

                                    {{ $w->nama }}

                                    -

                                    KK:

                                    {{ $w->no_kk }}

                                </option>

                            @endforeach

                        </select>

                    </div>



                    {{-- BULAN IURAN --}}

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Bulan Iuran
                        </label>

                        <select
                            name="kas_bulanan_id"
                            id="kas_bulanan_id"
                            class="form-select"
                            required
                        >

                            <option value="">
                                -- Pilih Bulan Iuran --
                            </option>

                            @foreach($kas as $k)

                                <option
                                    value="{{ $k->id }}"
                                    data-nominal="{{ $k->nominal }}"
                                >

                                    {{ $k->bulan }}

                                    {{ $k->tahun }}

                                    -

                                    Rp {{ number_format($k->nominal, 0, ',', '.') }}

                                </option>

                            @endforeach

                        </select>

                    </div>



                    {{-- INFORMASI PEMBAYARAN --}}

                    <div
                        id="infoPembayaran"
                        class="alert alert-secondary d-none mb-3"
                    >

                        <div class="d-flex justify-content-between mb-2">

                            <span>

                                <i class="fa-solid fa-wallet me-1"></i>

                                Nominal Iuran

                            </span>

                            <strong id="nominalIuran">
                                Rp 0
                            </strong>

                        </div>


                        <div class="d-flex justify-content-between mb-2">

                            <span>

                                <i class="fa-solid fa-circle-check me-1"></i>

                                Sudah Dibayar

                            </span>

                            <strong
                                id="sudahDibayar"
                                class="text-success"
                            >
                                Rp 0
                            </strong>

                        </div>


                        <hr>


                        <div class="d-flex justify-content-between">

                            <strong>

                                <i class="fa-solid fa-hourglass-half me-1"></i>

                                Sisa Pembayaran

                            </strong>

                            <strong
                                id="sisaPembayaran"
                                class="text-danger"
                            >
                                Rp 0
                            </strong>

                        </div>

                    </div>



                    {{-- JUMLAH --}}

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Jumlah Pembayaran
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rp
                            </span>

                            <input
                                type="number"
                                name="jumlah"
                                id="jumlahPembayaran"
                                class="form-control"
                                min="1"
                                step="1"
                                required
                                disabled
                                placeholder="Masukkan jumlah pembayaran"
                            >

                        </div>


                        <small
                            id="infoJumlah"
                            class="text-muted"
                        >

                            Pilih warga dan bulan iuran terlebih dahulu.

                        </small>

                    </div>



                    {{-- KETERANGAN --}}

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Keterangan
                        </label>

                        <textarea
                            name="keterangan"
                            class="form-control"
                            rows="3"
                            placeholder="Contoh: Pembayaran kas bulan September secara tunai"
                        ></textarea>

                    </div>



                    {{-- INFO --}}

                    <div class="alert alert-info mb-0">

                        <i class="fa-solid fa-circle-info me-2"></i>

                        Pembayaran admin akan dihitung dari sisa iuran warga.

                        Jika warga sudah membayar sebagian, admin hanya dapat
                        memasukkan jumlah sebesar sisa pembayaran.

                    </div>

                </div>



                {{-- FOOTER --}}

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>


                    <button
                        type="submit"
                        id="btnSimpanPembayaran"
                        class="btn btn-success"
                        disabled
                    >

                        <i class="fa-solid fa-floppy-disk me-2"></i>

                        Simpan Pembayaran Tunai

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    const wargaSelect =
        document.getElementById('warga_id');

    const kasSelect =
        document.getElementById('kas_bulanan_id');

    const jumlahInput =
        document.getElementById('jumlahPembayaran');

    const infoPembayaran =
        document.getElementById('infoPembayaran');

    const nominalIuran =
        document.getElementById('nominalIuran');

    const sudahDibayar =
        document.getElementById('sudahDibayar');

    const sisaPembayaran =
        document.getElementById('sisaPembayaran');

    const infoJumlah =
        document.getElementById('infoJumlah');

    const btnSimpan =
        document.getElementById('btnSimpanPembayaran');


    /*
    |--------------------------------------------------------------------------
    | DATA PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    const semuaPembayaran = @json($pembayaran);


    /*
    |--------------------------------------------------------------------------
    | FORMAT RUPIAH
    |--------------------------------------------------------------------------
    */

    function formatRupiah(angka) {

        return 'Rp ' +
            Number(angka).toLocaleString('id-ID');

    }


    /*
    |--------------------------------------------------------------------------
    | HITUNG SISA
    |--------------------------------------------------------------------------
    */

    function hitungSisa() {

        const wargaId =
            wargaSelect.value;

        const kasId =
            kasSelect.value;


        jumlahInput.value = '';

        jumlahInput.disabled = true;

        btnSimpan.disabled = true;

        infoPembayaran.classList.add('d-none');


        if (!wargaId || !kasId) {

            infoJumlah.textContent =
                'Pilih warga dan bulan iuran terlebih dahulu.';

            infoJumlah.classList.remove(
                'text-primary',
                'text-success',
                'text-danger'
            );

            infoJumlah.classList.add(
                'text-muted'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | NOMINAL KAS
        |--------------------------------------------------------------------------
        */

        const selectedKas =
            kasSelect.options[
                kasSelect.selectedIndex
            ];


        const nominal =
            Number(
                selectedKas.dataset.nominal || 0
            );


        /*
        |--------------------------------------------------------------------------
        | TOTAL PEMBAYARAN SEBELUMNYA
        |--------------------------------------------------------------------------
        */

        const totalSudahBayar =
            semuaPembayaran
                .filter(function (item) {

                    return String(item.warga_id) === String(wargaId)
                        &&
                        String(item.kas_bulanan_id) === String(kasId)
                        &&
                        [
                            'Lunas',
                            'Cicilan',
                            'Menunggu Verifikasi',
                            'Menunggu Konfirmasi'
                        ].includes(item.status);

                })
                .reduce(function (total, item) {

                    return total +
                        Number(item.jumlah || 0);

                }, 0);


        /*
        |--------------------------------------------------------------------------
        | HITUNG SISA
        |--------------------------------------------------------------------------
        */

        const sisa =
            Math.max(
                0,
                nominal - totalSudahBayar
            );


        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN
        |--------------------------------------------------------------------------
        */

        nominalIuran.textContent =
            formatRupiah(nominal);

        sudahDibayar.textContent =
            formatRupiah(totalSudahBayar);

        sisaPembayaran.textContent =
            formatRupiah(sisa);

        infoPembayaran.classList.remove(
            'd-none'
        );


        /*
        |--------------------------------------------------------------------------
        | SUDAH LUNAS
        |--------------------------------------------------------------------------
        */

        if (sisa <= 0) {

            sisaPembayaran.classList.remove(
                'text-danger'
            );

            sisaPembayaran.classList.add(
                'text-success'
            );

            infoJumlah.textContent =
                'Iuran untuk bulan ini sudah lunas.';

            infoJumlah.classList.remove(
                'text-muted',
                'text-primary',
                'text-danger'
            );

            infoJumlah.classList.add(
                'text-success'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | AKTIFKAN INPUT
        |--------------------------------------------------------------------------
        */

        jumlahInput.disabled = false;

        jumlahInput.max = sisa;

        jumlahInput.min = 1;

        jumlahInput.step = 1;


        infoJumlah.textContent =
            'Maksimal pembayaran: ' +
            formatRupiah(sisa);

        infoJumlah.classList.remove(
            'text-muted',
            'text-success',
            'text-danger'
        );

        infoJumlah.classList.add(
            'text-primary'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | VALIDASI JUMLAH
    |--------------------------------------------------------------------------
    */

    jumlahInput.addEventListener(
        'input',
        function () {

            const wargaId =
                wargaSelect.value;

            const kasId =
                kasSelect.value;


            if (!wargaId || !kasId) {

                btnSimpan.disabled = true;

                return;
            }


            const selectedKas =
                kasSelect.options[
                    kasSelect.selectedIndex
                ];


            const nominal =
                Number(
                    selectedKas.dataset.nominal || 0
                );


            const totalSudahBayar =
                semuaPembayaran
                    .filter(function (item) {

                        return String(item.warga_id) === String(wargaId)
                            &&
                            String(item.kas_bulanan_id) === String(kasId)
                            &&
                            [
                                'Lunas',
                                'Cicilan',
                                'Menunggu Verifikasi',
                                'Menunggu Konfirmasi'
                            ].includes(item.status);

                    })
                    .reduce(function (total, item) {

                        return total +
                            Number(item.jumlah || 0);

                    }, 0);


            const sisa =
                Math.max(
                    0,
                    nominal - totalSudahBayar
                );


            const jumlah =
                Number(
                    jumlahInput.value || 0
                );


            if (jumlah <= 0) {

                btnSimpan.disabled = true;

                return;
            }


            if (jumlah > sisa) {

                infoJumlah.textContent =
                    'Jumlah melebihi sisa pembayaran. Maksimal ' +
                    formatRupiah(sisa);

                infoJumlah.classList.remove(
                    'text-primary',
                    'text-success'
                );

                infoJumlah.classList.add(
                    'text-danger'
                );

                btnSimpan.disabled = true;

                return;
            }


            infoJumlah.textContent =
                'Pembayaran valid. Sisa setelah pembayaran: ' +
                formatRupiah(sisa - jumlah);


            infoJumlah.classList.remove(
                'text-primary',
                'text-danger'
            );

            infoJumlah.classList.add(
                'text-success'
            );


            btnSimpan.disabled = false;

        }
    );


    /*
    |--------------------------------------------------------------------------
    | PILIH WARGA
    |--------------------------------------------------------------------------
    */

    wargaSelect.addEventListener(
        'change',
        hitungSisa
    );


    /*
    |--------------------------------------------------------------------------
    | PILIH BULAN
    |--------------------------------------------------------------------------
    */

    kasSelect.addEventListener(
        'change',
        hitungSisa
    );


    /*
    |--------------------------------------------------------------------------
    | RESET MODAL
    |--------------------------------------------------------------------------
    */

    const modal =
        document.getElementById(
            'modalPembayaranTunai'
        );


    if (modal) {

        modal.addEventListener(
            'hidden.bs.modal',
            function () {

                wargaSelect.value = '';

                kasSelect.value = '';

                jumlahInput.value = '';

                jumlahInput.disabled = true;

                infoPembayaran.classList.add(
                    'd-none'
                );

                infoJumlah.textContent =
                    'Pilih warga dan bulan iuran terlebih dahulu.';

                infoJumlah.classList.remove(
                    'text-primary',
                    'text-success',
                    'text-danger'
                );

                infoJumlah.classList.add(
                    'text-muted'
                );

                btnSimpan.disabled = true;

            }
        );

    }

});
</script>

@endsection