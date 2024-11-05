@extends('layouts/contentNavbarLayout')

@section('title', 'create-jadwal')

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
            <form method="post" action="/dashboard/posyandu" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Masukkan Data Lokasi Posyandu</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="nama_posyandu">Nama Posyandu</label>
                                    <select class="form-control" id="nama_posyandu" name="nama_posyandu">
                                        <option value="">Pilih Nama Posyandu</option>
                                        <option value="Kipas">Kipas</option>
                                        <option value="Asyifa 1">Asyifa 1</option>
                                        <option value="Asyifa 2">Asyifa 2</option>
                                        <option value="Srikandi 1">Srikandi 1</option>
                                        <option value="Srikandi 2">Srikandi 2</option>
                                        <option value="Anggrek">Anggrek</option>
                                        <option value="Melati Putih 1">Melati Putih 1</option>
                                        <option value="Melati Putih 2">Melati Putih 2</option>
                                        <option value="Pergiwati">Pergiwati</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="dukuh">Dukuh</label>
                                    <select class="form-control" id="dukuh" name="dukuh">
                                        <option value="">Pilih Nama Dukuh</option>
                                        <option value="Cendono">Cendono</option>
                                        <option value="Madu">Madu</option>
                                        <option value="Kawakan">Kawakan</option>
                                        <option value="Dawe">Dawe</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="rt">RT</label>
                                    <select class="form-control" id="rt" name="rt">
                                        <option value="">Pilih RT</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="rw">RW</label>
                                    <select class="form-control" id="rw" name="rw">
                                        <option value="">Pilih RW</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    {{-- <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="tanggal">Tanggal Posyandu</label>
                                    <input type="date" id="tanggal" name="tanggal" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="jam_mulai">Jam Mulai</label>
                                    <input type="time" id="jam_mulai" name="jam_mulai" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="jam_selesai">Jam Selesai</label>
                                    <input type="time" id="jam_selesai" name="jam_selesai" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </form>
        </div>
    </div>

@endsection
