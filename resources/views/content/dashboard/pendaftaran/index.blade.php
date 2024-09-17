@extends('layouts/contentNavbarLayout')

@section('title', 'Pendaftaran')

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
    </h4>

    @if (auth()->check() && auth()->user()->role == 'petugas')
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 style="color: navy">Data Pendaftaran Posyandu</h5>
                    <a href="/dashboard/pendaftaran/create" class="btn btn-primary">Tambah Data Pendaftaran</a>
                </div>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ url('/dashboard/pendaftaran') }}" class="row g-3 mb-4">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex">
                                <div class="me-2 col-md-9">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Cari berdasarkan Nama Balita atau NIK" value="{{ request('search') }}">
                                </div>
                                <div class="me-2 col-md-6">
                                    <select name="filter_posyandu" class="form-select">
                                        <option value="" disabled>Filter berdasarkan Posyandu</option>
                                        <option value="">Semua Posyandu</option>
                                        @foreach ($posyandu as $item)
                                            <option value="{{ $item->nama_posyandu }}"
                                                {{ request('filter_posyandu') == $item->nama_posyandu ? 'selected' : '' }}>
                                                {{ $item->nama_posyandu }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead class="table-primary">
                            <tr class="center">
                                <th>No</th>
                                <th>NIK </th>
                                <th>NAMA BALITA</th>
                                <th>JENIS KELAMIN </th>
                                <th>TANGGAL LAHIR</th>
                                <th>NAMA ORANG TUA </th>
                                <th>NAMA POSYANDU</th>
                                <th>DUKUH </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendaftarans as $pendaftaran)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pendaftaran->nik }}</td>
                                    <td>{{ $pendaftaran->nama_balita }}</td>
                                    <td>{{ $pendaftaran->jenis_kelamin }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->format('d-m-Y') }}</td>
                                    <td>{{ $pendaftaran->nama_ortu }}</td>
                                    <td>{{ $pendaftaran->nama_posyandu }}</td>
                                    <td>{{ $pendaftaran->dukuh }}</td>

                                    <td>

                                        <a href="/dashboard/editpendaftaran/{{ $pendaftaran->id }}" class="btn btn-warning"
                                            onclick="return confirmEdit()"><i class="bx bx-edit-alt me-1"></i></a>
                                        <a href="/dashboard/hapuspendaftaran/{{ $pendaftaran->id }}" class="btn btn-danger"
                                            onclick="return confirmDelete()"><i class="bx bx-trash me-1"></i></a>
                                        <a href="/dashboard/detailpendaftaran/{{ $pendaftaran->id }}"
                                            class="btn btn-primary"><i class="bi bi-eye-fill"></i></a>
                                    </td>
                                @empty
                                    <td colspan="9" class="text-center">Tidak ada data.</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Tombol navigasi paginate -->
        {{ $pendaftarans->links('pagination::bootstrap-4') }}
    @elseif(auth()->check() && auth()->user()->role == 'ortu')
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 style="color: navy">Pendaftaran Posyandu</h5>
                    <a href="/dashboard/pendaftaran/create" class="btn btn-primary">Tambah Data Anak</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead class="table-primary">
                            <tr class="center">
                                <th>No</th>
                                <th>NIK </th>
                                <th>NAMA BALITA</th>
                                <th>JENIS KELAMIN </th>
                                <th>TANGGAL LAHIR</th>
                                <th>NAMA ORANG TUA </th>
                                <th>NAMA POSYANDU</th>
                                <th>DUKUH </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendaftarans as $pendaftaran)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pendaftaran->nik }}</td>
                                    <td>{{ $pendaftaran->nama_balita }}</td>
                                    <td>{{ $pendaftaran->jenis_kelamin }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->format('d-m-Y') }}</td>
                                    <td>{{ $pendaftaran->nama_ortu }}</td>
                                    <td>{{ $pendaftaran->nama_posyandu }}</td>
                                    <td>{{ $pendaftaran->dukuh }}</td>

                                    <td>

                                        <a href="/dashboard/editpendaftaran/{{ $pendaftaran->id }}" class="btn btn-warning"
                                            onclick="return confirmEdit()"><i class="bx bx-edit-alt me-1"></i></a>
                                        <a href="/dashboard/hapuspendaftaran/{{ $pendaftaran->id }}" class="btn btn-danger"
                                            onclick="return confirmDelete()"><i class="bx bx-trash me-1"></i></a>
                                        <a href="/dashboard/detailpendaftaran/{{ $pendaftaran->id }}"
                                            class="btn btn-primary"><i class="bi bi-eye-fill"></i></a>
                                    </td>
                                @empty
                                    <td colspan="9" class="text-center">Tidak ada data.</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!--/ Striped Rows -->
    <script>
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus data ini?');
        }
    </script>
    <script>
        function confirmEdit() {
            return confirm('Apakah Anda yakin ingin mengedit data ini?');
        }
    </script>

@endsection
