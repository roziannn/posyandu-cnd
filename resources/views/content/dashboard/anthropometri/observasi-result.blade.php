@extends('layouts/contentNavbarLayout')

@section('title', 'Observasi')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4 class="card-title">Hasil Observasi Stunting</h4>
                <div class="col-md-4">
                    <form method="GET" action="{{ route('anthropometri.observasi', $dataObserv->id) }}"
                        class="d-flex align-items-center">
                        <div class="me-2">
                            <h6 class="mb-0">Pilih Bulan</h6>
                        </div>
                        <div class="me-2 flex-grow-1">
                            <select name="month" class="form-select" id="month-select">
                                @foreach ($getAllMonthsBased as $month)
                                    <option value="{{ $month }}" {{ $month == $selectedMonth ? 'selected' : '' }}>
                                        {{ $month }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <p><strong>Nama Balita:</strong> {{ $item->pendaftaran->nama_balita ?? 'Tidak diketahui' }}
                        </p>
                    </div>
                    <div class="col-md-6 mb-1">
                        <p><strong>Usia (bulan):</strong> {{ $item->usia ?? 'Tidak diketahui' }} bulan</p>
                    </div>
                    <div class="col-md-6 mb-1">
                        <p><strong>Jenis Kelamin:</strong>
                            {{ $item->pendaftaran->jenis_kelamin === 'perempuan' ? 'Perempuan' : ($dataObserv->pendaftaran->jenis_kelamin === 'laki-laki' ? 'Laki-Laki' : 'Tidak diketahui') }}
                        </p>

                    </div>
                    <div class="col-md-6 mb-1">
                        <p><strong>Berat/Tinggi Badan:</strong>
                            {{ $item->berat_badan ?? 'Tidak diketahui' }}kg/{{ $item->tinggi_badan ?? 'Tidak diketahui' }}cm
                        </p>
                    </div>
                </div>
                <hr>
                @if (is_numeric($item->z_score))
                    <strong>Status Stunting: <br></strong>
                    <div class="d-flex align-items-center">
                        <h5>
                            <span class="mt-3">
                                @if ($item->status_stunting == 'Stunting')
                                    <div class="badge bg-danger mt-2">Stunting</div>
                                @elseif ($item->status_stunting == 'Tinggi')
                                    <div class="badge bg-warning mt-2">Tinggi/Melebihi Batas Normal</div>
                                @else
                                    <div class="badge bg-success mt-2">Tidak Stunting/Normal</div>
                                @endif
                            </span>
                        </h5>
                    </div>
                    <strong>Keterangan<br></strong>
                    <p> {!! $pesan !!}</p>
                    <a href="{{ route('pertumbuhan.petugas', $dataObserv->id) }}" class="btn btn-warning">Lihat Grafik
                        Pertumbuhan</a>
                @else
                    <div class="text-center my-3">
                        <h5>Hasil observasi tidak ditemukan.</h5>
                        <p>Usia balita sudah tidak memenuhi ambang batas perhitungan stunting.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
