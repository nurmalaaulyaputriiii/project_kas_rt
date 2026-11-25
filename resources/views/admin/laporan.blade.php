@extends('layout.app')

@section('title', 'Laporan | SI-KAS RT')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h1 class="page-title">Laporan Kas</h1>
        <p class="page-subtitle">
            Rekap pemasukan dan pengeluaran kas Warga
        </p>
    </div>

    {{-- FILTER --}}
    <div class="card mb-4">
        <div class="card-body">

            <form method="GET" action="{{ route('admin.laporan') }}">

                <div class="row align-items-end">

                    <div class="col-md-4">
                        <label class="form-label">Bulan</label>

                        <select name="bulan" class="form-control">

                            @for($i = 1; $i <= 12; $i++)

                                <option value="{{ $i }}"
                                    {{ $bulan == $i ? 'selected' : '' }}>

                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}

                                </option>

                            @endfor

                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tahun</label>

                        <input
                            type="number"
                            name="tahun"
                            class="form-control"
                            value="{{ $tahun }}"
                        >
                    </div>

                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">
                            Tampilkan
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>


    {{-- RINGKASAN --}}
    <div class="row mb-4">

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">

                    <p class="text-muted mb-1">
                        Total Pemasukan
                    </p>

                    <h3>
                        Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                    </h3>

                </div>
            </div>
        </div>


        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">

                    <p class="text-muted mb-1">
                        Total Pengeluaran
                    </p>

                    <h3>
                        Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                    </h3>

                </div>
            </div>
        </div>


        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">

                    <p class="text-muted mb-1">
                        Saldo Kas
                    </p>

                    <h3>
                        Rp {{ number_format($saldo, 0, ',', '.') }}
                    </h3>

                </div>
            </div>
        </div>

    </div>


    {{-- PEMASUKAN --}}
    <div class="card mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Data Pemasukan
            </h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Sumber</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($pemasukan as $item)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $item->tanggal->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ $item->sumber }}
                            </td>

                            <td>
                                Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ $item->keterangan ?? '-' }}
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="5" class="text-center">
                                Belum ada data pemasukan.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- PENGELUARAN --}}
    <div class="card mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Data Pengeluaran
            </h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Keperluan</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($pengeluaran as $item)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $item->tanggal->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ $item->keperluan }}
                            </td>

                            <td>
                                Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ $item->keterangan ?? '-' }}
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="5" class="text-center">
                                Belum ada data pengeluaran.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection