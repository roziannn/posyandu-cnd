@extends('layouts/contentNavbarLayout')

@section('title', 'Anthropometri')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 style="color: navy">Data Anthropometri Laki - Laki</h5>
                <div>
                    <a href="{{ route('anthropometri.create') }}" class="btn btn-primary">Tambah Data</a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ url('/dashboard/anthropometri/laki-laki') }}" class="row g-3 mb-4">
                <div class="col-md-7 text">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1 me-2">
                            <input type="text" name="search" class="form-control w-100"
                                placeholder="Cari berdasarkan nama balita atau NIK" value="{{ request('search') }}">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr class="center">
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama Balita</th>
                            <th>BB Lahir</th>
                            <th>TB</th>
                            <th>BB</th>
                            <th>Actions</th>
                            <th>Observasi</th>
                            <th>Pertumbuhan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($anthropometriData as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->pendaftaran->nik }}</td>
                                <td>{{ $data->pendaftaran->nama_balita }}</td>
                                <td>{{ $data->pendaftaran->bb_lahir }}</td>
                                <td>{{ $data->tinggi_badan }}</td>
                                <td>{{ $data->berat_badan }}</td>
                                <td>
                                    <a href="{{ route('anthropometri.edit', $data->id) }}" class="btn btn-warning"
                                        onclick="return confirmEdit()"><i class="bx bx-edit-alt me-1"></i></a>
                                    <a href="{{ route('anthropometri.delete', $data->id) }}" class="btn btn-danger"
                                        onclick="return confirmDelete()"><i class="bx bx-trash me-1"></i></a>
                                    <a href="/dashboard/detailanthropometri/{{ $data->id }}" class="btn btn-primary"><i
                                            class="bi bi-eye-fill"></i></a>
                                </td>
                                <td>
                                    <a href="{{ route('anthropometri.observasi', $data->id) }}" class="btn btn-success"><i
                                            class='bx bx-copy-alt'></i></a>
                                </td>
                                <td>
                                    <a href="{{ route('pertumbuhan.petugas', $data->id) }}" class="btn btn-info"><i
                                            class='bx bx-chart'></i></a>
                                </td>
                            </tr>
                        @empty
                            <td colspan="8" class="text-center">Tidak ada data.</td>
                        @endforelse
                    </tbody>
                </table>
                <!-- Tombol navigasi paginate -->
                {{ $anthropometriData->links('pagination::bootstrap-4') }}
            </div>
        </div>

        <script>
            function confirmDelete() {
                return confirm('Apakah Anda yakin ingin menghapus data ini?');
            }

            function confirmEdit() {
                return confirm('Apakah Anda yakin ingin mengedit data ini?');
            }
        </script>

    @endsection
