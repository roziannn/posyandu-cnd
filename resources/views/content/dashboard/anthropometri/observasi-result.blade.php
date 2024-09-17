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
                <a href="#" class="btn btn-primary">Lihat Detail Balita</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <p><strong>Nama Balita:</strong> {{ $dataObserv->pendaftaran->nama_balita ?? 'Tidak diketahui' }}
                        </p>
                    </div>
                    <div class="col-md-6 mb-1">
                        <p><strong>Usia (bulan):</strong> {{ $usiaBalita ?? 'Tidak diketahui' }} bulan</p>
                    </div>
                    <div class="col-md-6 mb-1">
                        <p><strong>Jenis Kelamin:</strong>
                            {{ $dataObserv->pendaftaran->jenis_kelamin === 'perempuan' ? 'Perempuan' : ($dataObserv->pendaftaran->jenis_kelamin === 'laki-laki' ? 'Laki-Laki' : 'Tidak diketahui') }}
                        </p>

                    </div>
                    <div class="col-md-6 mb-1">
                        <p><strong>Berat/Tinggi Badan:</strong>
                            {{ $dataObserv->berat_badan ?? 'Tidak diketahui' }}kg/{{ $dataObserv->tinggi_badan ?? 'Tidak diketahui' }}cm
                        </p>
                    </div>
                </div>
                <hr>
                @if (is_numeric($dataObserv->z_score))
                    <strong>Status Stunting: <br></strong>
                    <h5>
                        <span class="mt-3">
                            @if ($result['status'] == 'Stunting')
                                <div class="badge bg-danger mt-2">Stunting</div>
                            @elseif ($result['status'] == 'Tinggi')
                                <div class="badge bg-warning mt-2">Tinggi/Melebihi Batas Normal</div>
                            @else
                                <div class="badge bg-success mt-2">Tidak Stunting/Normal</div>
                            @endif
                        </span>
                    </h5>
                    <strong>Keterangan<br></strong>
                    <p> {!! $result['keterangan'] !!}</p>
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
