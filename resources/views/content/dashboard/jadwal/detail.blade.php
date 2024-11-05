@extends('layouts/contentNavbarLayout')

@section('title', 'Detail Jadwal Posyandu')

@section('content')

    <style>
        .form-label {
            font-size: 14px;
            /* Ukuran huruf label form */
            font-weight: bold;
            /* Membuat huruf tebal */
        }

        .card-header h5 {
            font-size: 18px;
            /* Ukuran huruf judul form */
            font-weight: bold;
            /* Membuat huruf tebal */
        }
    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Data Posyandu</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="nama_posyandu">Nama Posyandu</label>
                        <p>{{ $jadwal->nama_posyandu }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="dukuh">Dukuh</label>
                        <p>{{ $jadwal->dukuh }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="rt">RT</label>
                        <p>{{ $jadwal->rt }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="rw">RW</label>
                        <p>{{ $jadwal->rw }}</p>
                    </div>
                    {{-- <div class="mb-3">
                    <label class="form-label" for="tanggal">Tanggal Posyandu</label>
                    <p>{{ $jadwal->tanggal }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="jam_mulai">Jam Mulai</label>
                    <p>{{ $jadwal->jam_mulai }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="jam_selesai">Jam Selesai</label>
                    <p>{{ $jadwal->jam_selesai }}</p>
                </div> --}}
                    <div class="mb-3">
                        <label class="form-label" for="username">Username</label>
                        <p>{{ $jadwal->username }}</p>
                    </div>
                    <a href="/dashboard/posyandu" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>

@endsection
