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
            {{-- <form
                action="{{ $gender === 'laki-laki' ? route('anthropometri.laki.store') : route('anthropometri.perempuan.store') }}"
                method="POST"> --}}
            <form action="{{ route('anthropometri.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="text" class="form-control" id="nik" value="{{ old('nik') }}" name="nik"
                        required>
                </div>
                <div class="mb-3">
                    <label for="nama_balita" class="form-label">Nama Balita</label>
                    <input type="text" class="form-control" id="nama_balita" name="nama_balita"
                        value="{{ old('nama_balita') }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin" readonly>
                </div>
                <div class="mb-3">
                    <label for="tinggi_badan" class="form-label">Tinggi Badan</label>
                    <input type="text" class="form-control" id="tinggi_badan" name="tinggi_badan" required>
                </div>
                <div class="mb-3">
                    <label for="berat_badan" class="form-label">Berat Badan</label>
                    <input type="text" class="form-control" id="berat_badan" name="berat_badan" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
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
