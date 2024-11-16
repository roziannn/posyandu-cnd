@extends('layouts/contentNavbarLayout')

@section('title', 'Detail Lokasi Posyandu')

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
                        <p>{{ $lokasi->nama_posyandu }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="dukuh">Dukuh</label>
                        <p>{{ $lokasi->dukuh }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="rt">RT</label>
                        <p>{{ $lokasi->rt }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="rw">RW</label>
                        <p>{{ $lokasi->rw }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="username">Username</label>
                        <p>{{ $lokasi->username }}</p>
                    </div>
                    <a href="/dashboard/lokasi-posyandu" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>

@endsection
