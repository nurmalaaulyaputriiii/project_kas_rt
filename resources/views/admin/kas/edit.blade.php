@extends('layout.app')

@section('title', 'Edit Kas Bulanan')

@section('content')

<div class="topbar">

    <div>
        <h1 class="page-title">
            Edit Kas Bulanan
        </h1>

        <div class="page-subtitle">
            Perbarui data kas bulanan
        </div>
    </div>

</div>

<div class="form-card">

    <form action="{{ route('admin.kas.update', $kas->id) }}"
          method="POST">

        @csrf
        @method('PUT')


        <div class="mb-3">

            <label class="form-label">
                Bulan
            </label>

            <select name="bulan"
                    class="form-select"
                    required>

                @foreach([
                    'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                ] as $bulan)

                    <option value="{{ $bulan }}"
                        {{ $kas->bulan == $bulan ? 'selected' : '' }}>

                        {{ $bulan }}

                    </option>

                @endforeach

            </select>

        </div>


        <div class="mb-3">

            <label class="form-label">
                Tahun
            </label>

            <input type="number"
                   name="tahun"
                   class="form-control"
                   value="{{ $kas->tahun }}"
                   required>

        </div>


        <div class="mb-3">

            <label class="form-label">
                Nominal Kas
            </label>

            <input type="number"
                   name="nominal"
                   class="form-control"
                   value="{{ $kas->nominal }}"
                   min="0"
                   required>

        </div>


        <div class="mb-4">

            <label class="form-label">
                Jatuh Tempo
            </label>

            <input type="date"
                   name="jatuh_tempo"
                   class="form-control"
                   value="{{ $kas->jatuh_tempo ? $kas->jatuh_tempo->format('Y-m-d') : '' }}">

        </div>


        <a href="{{ route('admin.kas.index') }}"
           class="btn btn-secondary">

            Kembali

        </a>

        <button type="submit"
                class="btn btn-primary-custom">

            <i class="fa-solid fa-save"></i>
            Update

        </button>

    </form>

</div>

@endsection