@extends('layouts/contentNavbarLayout')

@section('title', 'Jadwal')

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

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div class="">
                    <h5 style="color: navy">Data Jadwal Posyandu</h5>
                </div>
                <div class="">
                    <a href="/dashboard/jadwal/create" class="btn btn-primary">Tambah Data Jadwal</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ url('/dashboard/jadwal') }}" class="row g-3 mb-4">
                <div class="col-md-7 text">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1 me-2">
                            <input type="text" name="search" class="form-control w-100"
                                placeholder="Cari berdasarkan nama posyandu/dukuh" value="{{ request('search') }}">
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
                            <th>NAMA POSYANDU</th>
                            <th>DUKUH</th>
                            <th>RT</th>
                            <th>RW</th>
                            <th>TANGGAL</th>
                            <th>JAM MULAI</th>
                            <th>JAM SELESAI</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwals as $jadwal)
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
                                    <a href="javascript:void(0);" class="btn btn-warning"
                                        onclick="return confirmEdit({{ $jadwal->id }})"><i
                                            class="bx bx-edit-alt me-1"></i></a>
                                    <a href="javascript:void(0);" class="btn btn-danger"
                                        onclick="confirmDelete({{ $jadwal->id }})">
                                        <i class="bx bx-trash me-1"></i>
                                    </a>
                                    <a href="/dashboard/detailjadwal/{{ $jadwal->id }}" class="btn btn-primary"><i
                                            class="bx bx-show"></i></a>
                                </td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Tombol navigasi paginate -->
        {{ $jadwals->links('pagination::bootstrap-4') }}
    </div>

@endsection
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
                window.location.href = '/dashboard/hapusjadwal/' + id;
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
                window.location.href = '/dashboard/editjadwal/' + id;
            }
        });
    }
</script>
