<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pendaftaran - PDF</title>
    <style>
        /* Add your styling here */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            font-size: 10px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        #infoCetak {
            font-size: 9px;
            color: grey;
        }

        #judul {
            text-align: center;
        }
    </style>
</head>

<body>
    <h5 id="judul">LAPORAN PENDAFTARAN POSYANDU
        <span>PERIODE: {{ $startDate }} - {{ $endDate }}</span>
    </h5>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>NIK</th>
                <th>NAMA</th>
                <th>JK</th>
                <th>TGL LAHIR</th>
                <th>BB LAHIR</th>
                <th>NAMA ORTU</th>
                <th>POSYANDU</th>
                <th>RT</th>
                <th>RW</th>
                <th>ALAMAT</th>
                <th>TGL DAFTAR</th>
                <th>TINGGI BADAN</th>
                <th>BERAT BADAN</th>
                <th>Z-SOCRE</th>
                <th>USIA (BULAN)</th>
            </tr>
        </thead>
        <tbody>
            @php
                use Illuminate\Support\Carbon;
            @endphp
            @foreach ($pendaftarans as $index => $pendaftaran)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pendaftaran->nik }}</td>
                    <td>{{ strtoupper($pendaftaran->nama_balita) }}</td>
                    <td>{{ strtoupper($pendaftaran->jenis_kelamin) }}</td>
                    <td>{{ Carbon::parse($pendaftaran->tanggal_lahir)->format('d/m/Y') }}</td>
                    <td>{{ strtoupper($pendaftaran->bb_lahir) }}</td>
                    <td>{{ strtoupper($pendaftaran->nama_ortu) }}</td>
                    <td>{{ strtoupper($pendaftaran->jadwal->nama_posyandu ?? 'N/A') }}</td>
                    <td>{{ strtoupper($pendaftaran->rt) }}</td>
                    <td>{{ strtoupper($pendaftaran->rw) }}</td>
                    <td>{{ strtoupper($pendaftaran->dukuh) }}</td>
                    <td>{{ $pendaftaran->created_at->format('d/m/Y') }}</td>
                    <td>{{ $pendaftaran->berat_badan ?? 'N/A' }}</td>
                    <td>{{ $pendaftaran->tinggi_badan ?? 'N/A' }}</td>
                    <td>{{ number_format($pendaftaran->z_score, 2, '.', '') }}</td>
                    <td>{{ $pendaftaran->usia }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p id="infoCetak">Dicetak pada {{ $infoCetak }}</p>
</body>

</html>
