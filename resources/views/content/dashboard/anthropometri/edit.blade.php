@extends('layouts/contentNavbarLayout')

@section('title', 'Tambah Data Anthropometri')

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

    <div class="card">
        <div class="card-body">
            <form action="{{ route('anthropometri.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="text" class="form-control" id="nik" value="{{ $dataAnthropo->pendaftaran->nik }}"
                        name="nik" required>
                </div>
                <div class="mb-3">
                    <label for="nama_balita" class="form-label">Nama Balita</label>
                    <input type="text" class="form-control" id="nama_balita"
                        value="{{ $dataAnthropo->pendaftaran->nama_balita }}" name="nama_balita" readonly>
                </div>
                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <input type="text" class="form-control" id="jenis_kelamin"
                        value="{{ $dataAnthropo->pendaftaran->jenis_kelamin }}" name="jenis_kelamin" readonly>
                </div>

                <div class="mb-3">
                    <label for="tinggi_badan" class="form-label">Tinggi Badan</label>
                    <input type="text" class="form-control" id="tinggi_badan" value="{{ $dataAnthropo->tinggi_badan }}"
                        name="tinggi_badan" required>
                </div>
                <div class="mb-3">
                    <label for="berat_badan" class="form-label">Berat Badan</label>
                    <input type="text" class="form-control" id="berat_badan" value="{{ $dataAnthropo->berat_badan }}"
                        name="berat_badan" required>
                </div>
                <div class="mb-3">
                    <div class="alert alert-info medium">
                        *Informasi tinggi dan berat badan diatas merupakan data terakhir balita pertanggal
                        {{ $dataAnthropo->created_at->format('d/m/y') }}.
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <h5>Riwayat Pertumbuhan</h5>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahRiwayat">Tambah Data</button>
            </div>
        </div>
        <div class="card-body">
            <table>
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead class="table-primary">
                            <tr class="center">
                                <th>BERAT BADAN</th>
                                <th>TINGGI BADAN</th>
                                <th>CARA UKUR</th>
                                <th>BULAN/TAHUN PENGUKURAN</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>92</td>
                                <td>14.5</td>
                                <td>Berdiri</td>
                                <td>07/2024</td>

                                <td>
                                    <a href="/dashboard/hapusjadwal/" class="btn btn-danger"
                                        onclick="return confirmDelete()"><i class="bx bx-trash me-1"></i></a>

                                </td>
                                {{-- @foreach ($jadwals as $jadwal)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $jadwal->nama_posyandu }}</td>
                                    <td>{{ $jadwal->dukuh }}</td>
                                    <td>{{ $jadwal->rt }}</td>
                                    <td>{{ $jadwal->rw }}</td>
                                    <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ $jadwal->jam_mulai }}</td>
                                    <td>{{ $jadwal->jam_selesai }}</td>
                                    <td>
                                        <a href="/dashboard/editjadwal/{{ $jadwal->id }}" class="btn btn-warning"
                                            onclick="return confirmEdit()"><i class="bx bx-edit-alt me-1"></i></a>
                                        <a href="/dashboard/hapusjadwal/{{ $jadwal->id }}" class="btn btn-danger"
                                            onclick="return confirmDelete()"><i class="bx bx-trash me-1"></i></a>
                                        <a href="/dashboard/detailjadwal/{{ $jadwal->id }}" class="btn btn-primary"><i
                                                class="bx bx-show"></i></a>
                                    </td>
                            @endforeach --}}
                                {{-- <td colspan="5" class="text-center">Tidak ada riwayat.</td> --}}
                        </tbody>
                    </table>
                </div>
            </table>
        </div>
    </div>

    <div class="modal fade" id="tambahRiwayat" tabindex="-1" aria-labelledby="tambahRiwayat" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahRiwayat">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="namaData" class="form-label">Bulan Pengukuran</label>
                            <select name="" id="" class="form-control">
                                <option value="">
                                    Januari
                                </option>
                                <option value="">
                                    Februari
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="namaData" class="form-label">Tahun</label>
                            <select name="" id="" class="form-control">
                                <option value="">
                                    2024
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="namaData" class="form-label">Tinggi Badan</label>
                            <input type="text" class="form-control" id="namaData"
                                placeholder="Masukkan angka dalam (cm)">
                        </div>
                        <div class="mb-3">
                            <label for="deskripsiData" class="form-label">Berat Badan</label>
                            <input type="text" class="form-control" id="namaData"
                                placeholder="Masukkan angka dalam (kg)">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('nik').addEventListener('blur', function() {
            const nik = this.value;
            if (nik) {
                fetch(`/api/pendaftaran/${nik}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                            document.getElementById('nama_balita').value = '';
                        } else {
                            document.getElementById('nama_balita').value = data.nama_balita;
                            document.getElementById('jenis_kelamin').value = data.jenis_kelamin;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    </script>
@endsection
