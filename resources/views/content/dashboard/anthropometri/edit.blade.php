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
    @if (session('whatsappUrl'))
        <p id="whatsapp-message">Anda akan dialihkan ke WhatsApp...</p>
        <script>
            setTimeout(function() {
                window.open("{{ session('whatsappUrl') }}", "_blank");
            }, 1000);

            setTimeout(function() {
                var message = document.getElementById("whatsapp-message");
                if (message) {
                    message.style.display = 'none';
                }
            }, 5000);
        </script>
        {{ session()->forget('whatsappUrl') }}
    @endif

    <a href="{{ $dataAnthropo->pendaftaran->jenis_kelamin === 'laki-laki' ? '/dashboard/anthropometri/laki-laki' : '/dashboard/anthropometri/perempuan' }}"
        class="btn btn-secondary mb-3">Kembali</a>
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
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered text-center">
                    <thead class="table-primary">
                        <tr class="center">
                            <th width="1%">NO.</th>
                            <th>BULAN/TAHUN</th>
                            <th>BERAT BADAN (kg)</th>
                            <th>TINGGI BADAN (cm)</th>
                            <th>Z-SCORE</th>
                            <th>USIA SAAT DIUKUR</th>
                            <th width="1%">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @forelse ($riwayat as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item->bulan }}/{{ $item->tahun }}</td>
                                <td>{{ $item->berat_badan }}</td>
                                <td>{{ $item->tinggi_badan }}</td>
                                <td>{{ is_numeric($item->z_score) ? number_format($item->z_score, 2, '.', '') : 'N/A' }}
                                </td>
                                <td>{{ $item->usia }} bulan</td>
                                <td>
                                    <a href="javascript:void(0);" class="btn btn-danger"
                                        onclick="confirmDelete({{ $item->id }})">
                                        <i class="bx bx-trash me-1"></i>
                                    </a>
                                </td>
                            @empty
                            <tr>
                                <td colspan="7">Tidak ada riwayat pertumbuhan.</td>
                            </tr>
                        @endforelse
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
                <form action="{{ route('pertumbuhan.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="hidden">
                            <input type="text" name="anthropometri_id" class="form-control"
                                value="{{ $dataAnthropo->id }}" hidden>
                            <input type="text" name="pendaftaran_id" class="form-control"
                                value="{{ $dataAnthropo->pendaftaran_id }}" hidden>
                            <input type="text" name="jenis_kelamin" class="form-control"
                                value="{{ $dataAnthropo->jenis_kelamin }}" hidden>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bulan/Tahun Pengukuran</label>
                            <input type="month" class="form-control" name="bulan" min="2020-01" max="2025-12"
                                value="2024-09">
                        </div>
                        <div class="mb-3">
                            <labelclass="form-label">Cara Ukur</label>
                            <select name="cara_ukur" id="" class="form-control">
                                <option value="berdiri">
                                    Berdiri
                                </option>
                                <option value="terlentang">
                                    Terlentang
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="namaData" class="form-label">Tinggi Badan</label>
                            <input type="text" class="form-control" name="tinggi_badan"
                                placeholder="Masukkan angka dalam (cm)">
                        </div>
                        <div class="mb-3">
                            <label for="deskripsiData" class="form-label">Berat Badan</label>
                            <input type="text" class="form-control" name="berat_badan"
                                placeholder="Masukkan angka dalam (kg)">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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

        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/dashboard/anthropometri/riwayat/delete/' + id;
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Data berhasil dihapus.",
                        icon: "success",
                        timer: 3000,
                        showConfirmButton: false
                    });
                }
            });
        }
    </script>

@endsection
