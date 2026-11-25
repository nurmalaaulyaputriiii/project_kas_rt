@extends('layout.pengurus')

@section('title', 'Input Pembayaran Tunai | SI-KAS RT')

@section('content')

<style>
    .payment-wrapper {
        max-width: 1000px;
        margin: 0 auto;
    }

    .payment-card {
        background: #fff;
        border-radius: 18px;
        padding: 30px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
    }

    .payment-header {
        margin-bottom: 25px;
    }

    .payment-header h2 {
        margin: 0;
        color: #1e3a8a;
        font-size: 25px;
        font-weight: 700;
    }

    .payment-header p {
        margin-top: 6px;
        color: #64748b;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #334155;
    }

    .form-control {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 15px;
        box-sizing: border-box;
        background: #fff;
    }

    .form-control:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
    }

    .form-control:disabled {
        background: #f1f5f9;
        cursor: not-allowed;
    }

    .payment-info {
        display: none;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin: 25px 0;
    }

    .info-box {
        padding: 18px;
        border-radius: 14px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }

    .info-box span {
        display: block;
        font-size: 13px;
        color: #64748b;
        margin-bottom: 6px;
    }

    .info-box strong {
        font-size: 18px;
        color: #1e293b;
    }

    .info-box.sisa {
        background: #eff6ff;
        border-color: #bfdbfe;
    }

    .info-box.sisa strong {
        color: #2563eb;
    }

    .status-box {
        display: none;
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .status-cicilan {
        background: #fff7ed;
        color: #c2410c;
    }

    .status-lunas {
        background: #f0fdf4;
        color: #15803d;
    }

    .alert {
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #f0fdf4;
        color: #166534;
    }

    .alert-danger {
        background: #fef2f2;
        color: #991b1b;
    }

    .btn-submit {
        width: 100%;
        border: none;
        padding: 14px;
        border-radius: 10px;
        background: #2563eb;
        color: white;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        margin-top: 10px;
    }

    .btn-submit:hover {
        background: #1d4ed8;
    }

    .btn-submit:disabled {
        background: #94a3b8;
        cursor: not-allowed;
    }

    @media (max-width: 700px) {
        .payment-card {
            padding: 20px;
        }

        .payment-info {
            grid-template-columns: 1fr;
        }
    }
</style>


<div class="topbar">

    <div>
        <h1 class="page-title">
            Input Pembayaran
        </h1>

        <div class="page-subtitle">
            Input pembayaran kas warga secara tunai
        </div>
    </div>

</div>


<div class="payment-wrapper">

    {{-- PESAN SUCCESS --}}
    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- PESAN ERROR --}}
    @if(session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


    {{-- VALIDATION ERROR --}}
    @if($errors->any())

        <div class="alert alert-danger">

            <ul style="margin:0;padding-left:20px;">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="payment-card">

        <div class="payment-header">

            <h2>
                Pembayaran Kas Tunai
            </h2>

            <p>
                Pilih warga dan bulan iuran yang akan dibayarkan.
            </p>

        </div>


        <form
            action="{{ route('pengurus.pembayaran.store') }}"
            method="POST"
            id="paymentForm"
        >

            @csrf


            {{-- ========================================== --}}
            {{-- WARGA --}}
            {{-- ========================================== --}}

            <div class="form-group">

                <label for="warga_id">
                    Nama Warga
                </label>

                <select
                    name="warga_id"
                    id="warga_id"
                    class="form-control"
                    required
                >

                    <option value="">
                        -- Pilih Warga --
                    </option>

                    @foreach($wargas as $warga)

                        <option
                            value="{{ $warga->id }}"
                            {{ old('warga_id') == $warga->id ? 'selected' : '' }}
                        >

                            {{ $warga->nama }}

                            @if($warga->no_kk)
                                - KK {{ $warga->no_kk }}
                            @endif

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- ========================================== --}}
            {{-- IURAN --}}
            {{-- ========================================== --}}

            <div class="form-group">

                <label for="kas_bulanan_id">
                    Iuran Bulanan
                </label>

                <select
                    name="kas_bulanan_id"
                    id="kas_bulanan_id"
                    class="form-control"
                    disabled
                    required
                >

                    <option value="">
                        -- Pilih Warga Terlebih Dahulu --
                    </option>

                </select>

            </div>


            {{-- ========================================== --}}
            {{-- INFO PEMBAYARAN --}}
            {{-- ========================================== --}}

            <div
                class="payment-info"
                id="paymentInfo"
            >

                <div class="info-box">

                    <span>
                        Nominal Iuran
                    </span>

                    <strong id="nominalIuran">
                        Rp 0
                    </strong>

                </div>


                <div class="info-box">

                    <span>
                        Sudah Dibayar
                    </span>

                    <strong id="sudahDibayar">
                        Rp 0
                    </strong>

                </div>


                <div class="info-box sisa">

                    <span>
                        Sisa Pembayaran
                    </span>

                    <strong id="sisaPembayaran">
                        Rp 0
                    </strong>

                </div>

            </div>


            {{-- ========================================== --}}
            {{-- STATUS --}}
            {{-- ========================================== --}}

            <div
                class="status-box"
                id="statusBox"
            ></div>


            {{-- ========================================== --}}
            {{-- JUMLAH --}}
            {{-- ========================================== --}}

            <div class="form-group">

                <label for="jumlah">
                    Jumlah Pembayaran
                </label>

                <input
                    type="number"
                    name="jumlah"
                    id="jumlah"
                    class="form-control"
                    min="1"
                    step="any"
                    inputmode="numeric"
                    value="{{ old('jumlah') }}"
                    placeholder="Masukkan jumlah pembayaran"
                    disabled
                    required
                >

            </div>


            {{-- ========================================== --}}
            {{-- KETERANGAN --}}
            {{-- ========================================== --}}

            <div class="form-group">

                <label for="keterangan">
                    Keterangan
                </label>

                <textarea
                    name="keterangan"
                    id="keterangan"
                    class="form-control"
                    rows="3"
                    placeholder="Keterangan pembayaran (opsional)"
                >{{ old('keterangan') }}</textarea>

            </div>


            {{-- METODE --}}
            <input
                type="hidden"
                name="metode_pembayaran"
                value="Tunai"
            >


            {{-- BUTTON --}}
            <button
                type="submit"
                class="btn-submit"
                id="submitButton"
                disabled
            >

                Simpan Pembayaran Tunai

            </button>

        </form>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const wargaSelect =
        document.getElementById('warga_id');

    const kasSelect =
        document.getElementById('kas_bulanan_id');

    const jumlahInput =
        document.getElementById('jumlah');

    const paymentInfo =
        document.getElementById('paymentInfo');

    const nominalIuran =
        document.getElementById('nominalIuran');

    const sudahDibayar =
        document.getElementById('sudahDibayar');

    const sisaPembayaran =
        document.getElementById('sisaPembayaran');

    const statusBox =
        document.getElementById('statusBox');

    const submitButton =
        document.getElementById('submitButton');


    /*
    |--------------------------------------------------------------------------
    | DATA DARI CONTROLLER
    |--------------------------------------------------------------------------
    */

    const kasData = @json($kas);

    const pembayaranData = @json($pembayaranData ?? []);


    /*
    |--------------------------------------------------------------------------
    | FORMAT RUPIAH
    |--------------------------------------------------------------------------
    */

    function rupiah(angka) {

        return 'Rp ' +
            Number(angka || 0)
                .toLocaleString('id-ID');

    }


    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    function resetPembayaran() {

        kasSelect.innerHTML =
            '<option value="">-- Pilih Iuran --</option>';

        kasSelect.disabled = true;

        jumlahInput.value = '';

        jumlahInput.disabled = true;

        jumlahInput.removeAttribute('max');

        jumlahInput.removeAttribute('step');

        jumlahInput.setAttribute('step', 'any');

        paymentInfo.style.display = 'none';

        statusBox.style.display = 'none';

        statusBox.innerHTML = '';

        submitButton.disabled = true;

    }


    /*
    |--------------------------------------------------------------------------
    | LOAD IURAN
    |--------------------------------------------------------------------------
    */

    function loadKas(wargaId) {

        kasSelect.innerHTML =
            '<option value="">-- Pilih Iuran --</option>';


        if (!wargaId) {

            resetPembayaran();

            return;

        }


        kasSelect.disabled = false;


        kasData.forEach(function (kas) {

            let data = null;


            /*
            |--------------------------------------------------------------------------
            | CARI DATA PEMBAYARAN WARGA
            |--------------------------------------------------------------------------
            */

            if (
                pembayaranData[wargaId] &&
                pembayaranData[wargaId][kas.id]
            ) {

                data =
                    pembayaranData[wargaId][kas.id];

            }


            /*
            |--------------------------------------------------------------------------
            | NOMINAL
            |--------------------------------------------------------------------------
            */

            const nominal = data
                ? Number(data.nominal || 0)
                : Number(kas.nominal || 0);


            /*
            |--------------------------------------------------------------------------
            | SUDAH DIBAYAR
            |--------------------------------------------------------------------------
            */

            const sudah = data
                ? Number(data.sudah_dibayar || 0)
                : 0;


            /*
            |--------------------------------------------------------------------------
            | SISA
            |--------------------------------------------------------------------------
            */

            const sisa = data
                ? Number(data.sisa || 0)
                : nominal;


            /*
            |--------------------------------------------------------------------------
            | TEXT OPTION
            |--------------------------------------------------------------------------
            */

            let text =
                kas.bulan +
                ' ' +
                kas.tahun;


            if (sisa <= 0) {

                text += ' - Lunas';

            } else {

                text +=
                    ' - Sisa ' +
                    rupiah(sisa);

            }


            /*
            |--------------------------------------------------------------------------
            | OPTION
            |--------------------------------------------------------------------------
            */

            const option =
                document.createElement('option');


            option.value =
                kas.id;

            option.textContent =
                text;

            option.dataset.nominal =
                nominal;

            option.dataset.sudah =
                sudah;

            option.dataset.sisa =
                sisa;


            /*
            |--------------------------------------------------------------------------
            | OLD VALUE
            |--------------------------------------------------------------------------
            */

            if (
                '{{ old('kas_bulanan_id') }}' ==
                kas.id
            ) {

                option.selected = true;

            }


            kasSelect.appendChild(option);

        });


        updatePayment();

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    function updatePayment() {

        const option =
            kasSelect.options[
                kasSelect.selectedIndex
            ];


        if (
            !option ||
            !option.value
        ) {

            paymentInfo.style.display = 'none';

            jumlahInput.disabled = true;

            jumlahInput.value = '';

            jumlahInput.removeAttribute('max');

            jumlahInput.removeAttribute('step');

            jumlahInput.setAttribute('step', 'any');

            submitButton.disabled = true;

            statusBox.style.display = 'none';

            return;

        }


        const nominal =
            Number(
                option.dataset.nominal || 0
            );


        const sudah =
            Number(
                option.dataset.sudah || 0
            );


        const sisa =
            Number(
                option.dataset.sisa || 0
            );


        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN INFORMASI
        |--------------------------------------------------------------------------
        */

        nominalIuran.textContent =
            rupiah(nominal);

        sudahDibayar.textContent =
            rupiah(sudah);

        sisaPembayaran.textContent =
            rupiah(sisa);

        paymentInfo.style.display =
            'grid';


        /*
        |--------------------------------------------------------------------------
        | SET INPUT
        |--------------------------------------------------------------------------
        */

        jumlahInput.removeAttribute('step');

        jumlahInput.setAttribute(
            'step',
            'any'
        );


        /*
        |--------------------------------------------------------------------------
        | SUDAH LUNAS
        |--------------------------------------------------------------------------
        */

        if (sisa <= 0) {

            jumlahInput.value = '';

            jumlahInput.disabled = true;

            jumlahInput.removeAttribute('max');

            submitButton.disabled = true;


            statusBox.className =
                'status-box status-lunas';


            statusBox.innerHTML =
                '✓ Iuran bulan ini sudah LUNAS.';


            statusBox.style.display =
                'block';


            return;

        }


        /*
        |--------------------------------------------------------------------------
        | BELUM LUNAS
        |--------------------------------------------------------------------------
        */

        jumlahInput.disabled = false;

        jumlahInput.max = sisa;


        statusBox.className =
            'status-box status-cicilan';


        statusBox.innerHTML =
            'Sisa tagihan: <strong>' +
            rupiah(sisa) +
            '</strong>';


        statusBox.style.display =
            'block';


        checkJumlah();

    }


    /*
    |--------------------------------------------------------------------------
    | CEK JUMLAH
    |--------------------------------------------------------------------------
    */

    function checkJumlah() {

        const option =
            kasSelect.options[
                kasSelect.selectedIndex
            ];


        if (
            !option ||
            !option.value
        ) {

            submitButton.disabled =
                true;

            return;

        }


        const sisa =
            Number(
                option.dataset.sisa || 0
            );


        const jumlah =
            Number(
                jumlahInput.value || 0
            );


        /*
        |--------------------------------------------------------------------------
        | VALID
        |--------------------------------------------------------------------------
        */

        if (
            jumlah > 0 &&
            jumlah <= sisa
        ) {

            submitButton.disabled =
                false;


            if (jumlah >= sisa) {

                statusBox.className =
                    'status-box status-lunas';


                statusBox.innerHTML =
                    '✓ Pembayaran ini akan membuat iuran menjadi LUNAS.';

            } else {

                statusBox.className =
                    'status-box status-cicilan';


                statusBox.innerHTML =
                    'Pembayaran sebagian. Status akan menjadi CICILAN.';

            }


            statusBox.style.display =
                'block';


        } else {

            submitButton.disabled =
                true;


            if (jumlah > sisa) {

                statusBox.className =
                    'status-box status-cicilan';


                statusBox.innerHTML =
                    'Jumlah pembayaran tidak boleh lebih dari ' +
                    '<strong>' +
                    rupiah(sisa) +
                    '</strong>.';


                statusBox.style.display =
                    'block';

            }

        }

    }


    /*
    |--------------------------------------------------------------------------
    | EVENT WARGA
    |--------------------------------------------------------------------------
    */

    wargaSelect.addEventListener(
        'change',
        function () {

            loadKas(this.value);

        }
    );


    /*
    |--------------------------------------------------------------------------
    | EVENT KAS
    |--------------------------------------------------------------------------
    */

    kasSelect.addEventListener(
        'change',
        updatePayment
    );


    /*
    |--------------------------------------------------------------------------
    | EVENT JUMLAH
    |--------------------------------------------------------------------------
    */

    jumlahInput.addEventListener(
        'input',
        function () {

            this.value =
                this.value.replace(
                    /[^0-9]/g,
                    ''
                );

            checkJumlah();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | VALIDASI SUBMIT
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('paymentForm')
        .addEventListener(
            'submit',
            function (event) {

                const option =
                    kasSelect.options[
                        kasSelect.selectedIndex
                    ];


                if (
                    !option ||
                    !option.value
                ) {

                    event.preventDefault();

                    alert(
                        'Silakan pilih iuran terlebih dahulu.'
                    );

                    return;

                }


                const sisa =
                    Number(
                        option.dataset.sisa || 0
                    );


                const jumlah =
                    Number(
                        jumlahInput.value || 0
                    );


                if (
                    jumlah <= 0 ||
                    jumlah > sisa
                ) {

                    event.preventDefault();

                    alert(
                        'Jumlah pembayaran tidak boleh lebih dari ' +
                        rupiah(sisa) +
                        '.'
                    );

                    return;

                }

            }
        );


    /*
    |--------------------------------------------------------------------------
    | LOAD ULANG SETELAH VALIDATION ERROR
    |--------------------------------------------------------------------------
    */

    if (wargaSelect.value) {

        loadKas(
            wargaSelect.value
        );

    }

});
</script>

@endsection