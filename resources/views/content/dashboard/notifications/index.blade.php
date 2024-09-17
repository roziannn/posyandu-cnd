@extends('layouts/contentNavbarLayout')
@section('content')
    <div class="card">
        <div class="card-header bg-primary pb-0 mb-4">
            <h5 class="text-white">Notifikasi</h5>
        </div>
        @if ($pendaftaran)
            <div class="card-body">
                <p>Halo <strong>{{ $pendaftaran->nama_ortu }}</strong>,</p>
                <p>Kami ingin menginformasikan bahwa hasil pengukuran Panjang Badan/Tinggi Badan (PB/TB) anak Anda,
                    <strong>{{ $pendaftaran->nama_balita }}</strong>,
                    yang berusia <strong>{{ $usia }}</strong> bulan adalah sebagai berikut:
                </p>

                <ul class="list-group mb-4">
                    <li class="list-group-item">
                        <strong>Sangat Pendek (Severely Stunted):</strong> Jika PB/TB di bawah -3 SD.<br>
                        <em>Saran:</em> Segera lakukan konsultasi ke tenaga kesehatan untuk mendapatkan penanganan yang
                        tepat.
                        Penting untuk meningkatkan asupan gizi, memperbaiki pola makan, serta memastikan anak mendapatkan
                        layanan kesehatan yang sesuai.
                    </li>
                    <li class="list-group-item">
                        <strong>Pendek (Stunted):</strong> Jika PB/TB berada di antara -3 SD dan < -2 SD.<br>
                            <em>Saran:</em> Konsultasikan kondisi anak ke puskesmas atau dokter spesialis gizi untuk
                            mendapatkan
                            saran tentang pola makan yang lebih baik,
                            suplemen jika diperlukan, dan pemantauan tumbuh kembang secara berkala.
                    </li>
                    <li class="list-group-item">
                        <strong>Normal:</strong> Jika PB/TB berada di antara -2 SD dan +3 SD.<br>
                        <em>Saran:</em> Pertahankan pola makan yang seimbang dan gizi yang cukup. Pastikan anak tetap
                        mendapatkan imunisasi dan layanan kesehatan yang diperlukan
                        untuk mendukung tumbuh kembangnya.
                    </li>
                    <li class="list-group-item">
                        <strong>Tinggi:</strong> Jika PB/TB di atas +3 SD.<br>
                        <em>Saran:</em> Kondisi ini biasanya tidak memerlukan intervensi khusus, namun tetap lakukan
                        pemantauan
                        tumbuh kembang secara rutin dan pastikan anak mendapatkan
                        asupan gizi yang seimbang.
                    </li>
                </ul>

                <p>Jika Anda memiliki pertanyaan atau memerlukan konsultasi lebih lanjut, jangan ragu untuk menghubungi
                    kami.
                </p>
                <p>Salam sehat,</p>
                <p><strong>Posyandu Cendono</strong></p>
            </div>
        @else
            <div class="card-body">
                <strong> Tidak ada Notifikasi. </strong>
            </div>
        @endif

    </div>
@endsection
