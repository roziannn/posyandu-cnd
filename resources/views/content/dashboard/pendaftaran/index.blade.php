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
                                <th>JK </th>
                                <th>TANGGAL LAHIR</th>
                                <th>NAMA ORANG TUA </th>
                                <th>POSYANDU</th>
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
                                        <a href="javascript:void(0);" class="btn btn-warning"
                                            onclick="return confirmEdit({{ $pendaftaran->id }})"><i
                                                class="bx bx-edit-alt me-1"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-danger"
                                            onclick="confirmDelete({{ $pendaftaran->id }})">
                                            <i class="bx bx-trash me-1"></i>
                                        </a>
                                        <a href="/dashboard/detailpendaftaran/{{ $pendaftaran->id }}"
                                            class="btn btn-primary"><i class="bi bi-eye-fill"></i></a>
                                    </td>
                                @empty
                                    <td colspan="9" class="text-center">Tidak ada data.</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Tombol navigasi paginate -->
                <div class="mt-4">
                    {{ $pendaftarans->links('pagination::bootstrap-4') }}
                </div>
            </div>
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
                                            <a href="javascript:void(0);" class="btn btn-warning"
                                                onclick="return confirmEdit({{ $pendaftaran->id }})"><i
                                                    class="bx bx-edit-alt me-1"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-danger"
                                                onclick="confirmDelete({{ $pendaftaran->id }})">
                                                <i class="bx bx-trash me-1"></i>
                                            </a>
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
                    window.location.href = '/dashboard/hapuspendaftaran/' + id;
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
    <script>
        function confirmEdit(id) {
            Swal.fire({
                title: 'Edit data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/dashboard/editpendaftaran/' + id;
                }
            });
        }
    </script>

@endsection
