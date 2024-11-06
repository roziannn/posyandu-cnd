@extends('layouts/contentNavbarLayout')

@section('title', 'Detail Pendaftaran')

@section('content')

    <style>
        .form-label {
            font-size: 14px;
            font-weight: bold;
        }

        .card-header h5 {
            font-size: 18px;
            font-weight: bold;
        }

        fieldset legend {
            font-size: 18px;
            font-weight: bold;
            color: #5e6a80;
        }
    </style>

    <a href="/dashboard/pendaftaran" class="btn btn-secondary mb-3">Kembali</a>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Pendaftaran Posyandu</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <fieldset>
                                <legend>Data Balita</legend>
                                <div class="mb-3">
                                    <label class="form-label" for="nama_posyandu">Nama Posyandu</label>
                                    <p>{{ $pendaftaran->nama_posyandu }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="nik">NIK</label>
                                    <p>{{ $pendaftaran->nik }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="nama_balita">Nama</label>
                                    <p>{{ $pendaftaran->nama_balita }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                                    <p>{{ $pendaftaran->tempat_lahir }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                                    <p>{{ $pendaftaran->tanggal_lahir }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                                    <p>{{ $pendaftaran->jenis_kelamin }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bb_lahir">Berat Badan Lahir</label>
                                    <p>{{ $pendaftaran->bb_lahir }} kg</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="tb_lahir">Tinggi Badan Lahir</label>
                                    <p>{{ $pendaftaran->tb_lahir }} cm</p>
                                </div>
                            </fieldset>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <fieldset>
                                <legend>Data Orang Tua</legend>
                                <div class="mb-3">
                                    <label class="form-label" for="nama_ortu">Nama</label>
                                    <p>{{ $pendaftaran->nama_ortu }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="email_ortu">Email Ortu</label>
                                    <p>{{ $pendaftaran->email_ortu }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="no_telepon">No WhatsApp</label>
                                    <p>{{ $pendaftaran->no_telepon }}</p>
                                </div>
                                <fieldset>
                                    <legend>Alamat Orang Tua</legend>
                                    <div class="mb-3">
                                        <label class="form-label" for="dukuh">Dukuh</label>
                                        <p>{{ $pendaftaran->dukuh }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="rt">RT</label>
                                        <p>{{ $pendaftaran->rt }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="rw">RW</label>
                                        <p>{{ $pendaftaran->rw }}</p>
                                    </div>
                                </fieldset>
                                <div class="mb-3">
                                    <label class="form-label" for="pekerjaan">Pekerjaan</label>
                                    <p>{{ $pendaftaran->pekerjaan }}
                                        @if ($pendaftaran->pekerjaan == 'Lainnya')
                                            - {{ $pendaftaran->pekerjaan_lainnya }}
                                        @endif
                                    </p>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>

            @if (!empty($dataMutasi) && $dataMutasi->isNotEmpty())
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Riwayat Perpindahan Posyandu</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered">
                                <thead class="table-primary">
                                    <tr class="center">
                                        <th width="1%">NO.</th>
                                        <th width="5%">Tanggal Pindah</th>
                                        <th>Detail Perpindahan</th>
                                        <th>By Username</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataMutasi as $key => $mutasi)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $mutasi->updated_at }}</td>
                                            <td>Pindah dari posyandu <span
                                                    class="text-info fw-bold">{{ $mutasi->fromPosyandu }} </span> ke
                                                posyandu <span
                                                    class="text-primary fw-bold">{{ $mutasi->toPosyandu }}</span></td>
                                            <td>{{ $mutasi->username }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>

    @endsection
