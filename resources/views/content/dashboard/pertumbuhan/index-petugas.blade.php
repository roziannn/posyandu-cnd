@extends('layouts/contentNavbarLayout')


@section('vendor-script')
    {{-- <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endsection

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

    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between">

                <h4 class="card-title">Pertumbuhan Balita</h4>
                <a href="{{ route('anthropometri.observasi', $data->id) }}" class="btn btn-primary">Detail Observasi</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <p><strong>Nama Balita:</strong>
                            {{ $data->pendaftaran->nama_balita ?? 'Tidak diketahui' }}
                        </p>
                    </div>
                    <div class="col-md-6 mb-1">
                        <p><strong>Usia (bulan):</strong> {{ $data->usia ?? 'Tidak diketahui' }} bulan</p>
                    </div>
                    <div class="col-md-6 mb-1">
                        <p><strong>Jenis Kelamin:</strong>
                            {{ $data->jenis_kelamin === 'perempuan' ? 'Perempuan' : ($data->jenis_kelamin === 'laki-laki' ? 'Laki-Laki' : 'Tidak diketahui') }}
                        </p>

                    </div>
                    <div class="col-md-6 mb-1">
                        <p><strong>Berat/Tinggi Badan:</strong>
                            {{ $data->berat_badan ?? 'Tidak diketahui' }}kg/{{ $data->tinggi_badan ?? 'Tidak diketahui' }}cm
                        </p>
                    </div>
                </div>
                <hr>

                @if ($zScore)
                    <div class="container">
                        <div class="row my-3">
                            <div class="col-md-4">
                                <form method="GET" action="{{ route('pertumbuhan.petugas', $data->id) }}"
                                    class="d-flex align-items-center">
                                    <div class="me-2">
                                        <h6 class="mb-0">Pilih Bulan</h6>
                                    </div>
                                    <div class="me-2 flex-grow-1">
                                        <select name="month" class="form-select" id="month-select">
                                            @foreach ($getAllMonthsBased as $month)
                                                <option value="{{ $month }}"
                                                    {{ $month == $selectedMonth ? 'selected' : '' }}>
                                                    {{ $month }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3" id="chartStat"></div>

                    <div id="description">
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead class="table-secondary">
                                    <tr>
                                        <th colspan="2" class="text-center"><strong>Kategori Rentang Ambang Batas
                                                (Z-Score)
                                                :</strong>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td id="tinggi" class="color-tall">Tinggi (+3 SD)</td>
                                    </tr>
                                    <tr>
                                        <td id="normal" class="color-normal">Normal (-2 SD sd +3 SD)</td>
                                    </tr>
                                    <tr>
                                        <td id="stunted" class="color-stunted">Pendek/stunted (-3 SD sd < -2 SD)</td>
                                    </tr>

                                    <tr>
                                        <td id="severely-stunted" class="color-severely-stunted">Sangat pendek/severely
                                            stunted ( < -3 SD)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="text-center my-3">
                        <h5>Grafik Pertumbuhan tidak ditemukan.</h5>
                        <p>Usia balita sudah tidak memenuhi ambang batas perhitungan stunting.</p>
                    </div>
                @endif


                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var zScores = @json($zScore);

                        var element;

                        if (zScores > -2 && zScores <= 3) {
                            element = document.getElementById('normal');
                            element.style.border = '2px solid blue';
                            element.style.fontWeight = '900';
                            element.style.backgroundColor = 'rgba(0, 0, 255, 0.2)';
                        } else if (zScores >= 3) {
                            element = document.getElementById('tinggi');
                            element.style.border = '2px solid orange';
                            element.style.fontWeight = '900';
                            element.style.backgroundColor = 'rgba(250, 196, 24, 0.5)';
                        } else if (zScores <= -2 && zScores > -3) {
                            element = document.getElementById('stunted');
                            element.style.border = '2px solid red';
                            element.style.fontWeight = '900';
                            element.style.backgroundColor = 'rgba(255, 0, 0, 0.2)';
                        } else if (zScores <= -3) {
                            element = document.getElementById('severely-stunted');
                            element.style.border = '2px solid darkred';
                            element.style.fontWeight = '900';
                            element.style.color = 'red';
                            element.style.backgroundColor = 'rgba(139, 0, 0, 0.3)';
                        }
                    });
                </script>
                <script>
                    // document.addEventListener('DOMContentLoaded', function() {
                    //     var zScoreLimits = @json($zScoreLimits);
                    //     var zScores = @json($zScore);
                    //     var ages = @json($ages);

                    //     var categories = ["0", "10", "20", "30", "40", "50", "60"]; // Kategori usia
                    //     var closestCategory = categories.reduce(function(prev, curr) {
                    //         return (Math.abs(curr - ages) < Math.abs(prev - ages) ? curr : prev);
                    //     });

                    //     var usiaData = ages;
                    //     var garisUsia = usiaData[0];

                    //     // Define y-axis max value and annotation value
                    //     var yAxisMax = 4;
                    //     var annotationYPosition = zScores > yAxisMax ? yAxisMax + 1 : zScores;
                    //     var isStunting = zScores <= -2;
                    //     var options = {
                    //         chart: {
                    //             height: 450,
                    //             type: "area"
                    //         },
                    //         dataLabels: {
                    //             enabled: true
                    //         },
                    //         series: [{
                    //             name: "Status",
                    //             data: zScoreLimits,
                    //             color: isStunting ? 'rgba(255, 83, 23, 0.8)' : 'rgba(84, 157, 255, 0.8)'
                    //         }],
                    //         fill: {
                    //             type: "gradient",
                    //             gradient: {
                    //                 shadeIntensity: 1,
                    //                 opacityFrom: 0.7,
                    //                 opacityTo: 0.9,
                    //                 stops: [0, 90, 100],
                    //                 colorStops: [{
                    //                         offset: 0,
                    //                         color: isStunting ? 'rgba(255, 83, 23, 0.8)' : 'rgba(84, 157, 255, 0.8)',
                    //                         opacity: 0.7
                    //                     },
                    //                     {
                    //                         offset: 100,
                    //                         color: isStunting ? 'rgba(255, 83, 23, 0.8)' : 'rgba(84, 157, 255, 0.8)',
                    //                         opacity: 0.9
                    //                     }
                    //                 ]
                    //             }
                    //         },
                    //         stroke: {
                    //             curve: 'smooth',
                    //             width: [6]
                    //         },
                    //         title: {
                    //             text: 'Grafik Analisa Stunting Anak Berdasarkan Hasil Z-Score',
                    //             align: 'left'
                    //         },
                    //         grid: {
                    //             row: {
                    //                 colors: ['#f3f3f3', 'transparent'],
                    //                 opacity: 0.5
                    //             }
                    //         },
                    //         xaxis: {
                    //             categories: categories,
                    //             title: {
                    //                 text: "Rentang Usia (Bulan)",
                    //                 style: {
                    //                     fontSize: '12px',
                    //                     fontWeight: 'bold'
                    //                 }
                    //             }
                    //         },
                    //         yaxis: {
                    //             min: -4,
                    //             max: 5,
                    //             labels: {
                    //                 formatter: function(value) {
                    //                     if (value > 3) {
                    //                         return "Tinggi";
                    //                     } else if (value > -2 && value <= 3) {
                    //                         return "Normal";
                    //                     } else {
                    //                         return "Stunting";
                    //                     }
                    //                 }
                    //             },
                    //             title: {
                    //                 text: "Stunting Status",
                    //                 align: 'left',
                    //                 style: {
                    //                     fontSize: '12px',
                    //                     fontWeight: 'bold'
                    //                 }
                    //             }
                    //         },
                    //         annotations: {
                    //             xaxis: [{
                    //                 x: closestCategory,
                    //                 borderColor: '#71DD37',
                    //                 strokeDashArray: 5,
                    //                 strokeWidth: 4,
                    //                 label: {
                    //                     borderColor: '#71DD37',
                    //                     style: {
                    //                         color: '#fff',
                    //                         background: '#71DD37'
                    //                     },
                    //                     text: 'Usia: ' + ages + ' bulan'
                    //                 }
                    //             }],
                    //             yaxis: [{
                    //                 y: annotationYPosition,
                    //                 borderColor: '#FF4560',
                    //                 strokeDashArray: 10,
                    //                 label: {
                    //                     borderColor: '#FF4560',
                    //                     style: {
                    //                         color: '#fff',
                    //                         background: '#FF4560'
                    //                     },
                    //                     text: 'Z-Score: ' + zScores
                    //                 }
                    //             }]
                    //         }
                    //     };

                    //     var chart = new ApexCharts(document.querySelector("#chartStat"), options);
                    //     chart.render();
                    // });
                    document.addEventListener('DOMContentLoaded', function() {
                        var zScoreLimits = @json($zScoreLimits);
                        var zScores = @json($zScore);
                        var ages = @json($ages);

                        var categories = ["0", "10", "20", "30", "40", "50", "60"]; // Kategori usia
                        var closestCategory = categories.reduce(function(prev, curr) {
                            return (Math.abs(curr - ages) < Math.abs(prev - ages) ? curr : prev);
                        });

                        var usiaData = ages;
                        var garisUsia = usiaData[0];

                        //  y-axis max value
                        var yAxisMax = 4;
                        var annotationYPosition;

                        // cek if zScores is < -3
                        if (zScores < -3) {
                            annotationYPosition = -4; // set minimum (label dibawah -3) y-axis
                        } else {
                            annotationYPosition = zScores > yAxisMax ? yAxisMax + 1 : zScores;
                        }

                        var isStunting = zScores <= -2;
                        var options = {
                            chart: {
                                height: 450,
                                type: "area"
                            },
                            dataLabels: {
                                enabled: true
                            },
                            series: [{
                                name: "Status",
                                data: zScoreLimits,
                                color: isStunting ? 'rgba(255, 83, 23, 0.8)' : 'rgba(84, 157, 255, 0.8)'
                            }],
                            fill: {
                                type: "gradient",
                                gradient: {
                                    shadeIntensity: 1,
                                    opacityFrom: 0.7,
                                    opacityTo: 0.9,
                                    stops: [0, 90, 100],
                                    colorStops: [{
                                            offset: 0,
                                            color: isStunting ? 'rgba(255, 83, 23, 0.8)' : 'rgba(84, 157, 255, 0.8)',
                                            opacity: 0.7
                                        },
                                        {
                                            offset: 100,
                                            color: isStunting ? 'rgba(255, 83, 23, 0.8)' : 'rgba(84, 157, 255, 0.8)',
                                            opacity: 0.9
                                        }
                                    ]
                                }
                            },
                            stroke: {
                                curve: 'smooth',
                                width: [6]
                            },
                            title: {
                                text: 'Grafik Analisa Stunting Anak Berdasarkan Hasil Z-Score',
                                align: 'left'
                            },
                            grid: {
                                row: {
                                    colors: ['#f3f3f3', 'transparent'],
                                    opacity: 0.5
                                }
                            },
                            xaxis: {
                                categories: categories,
                                title: {
                                    text: "Rentang Usia (Bulan)",
                                    style: {
                                        fontSize: '12px',
                                        fontWeight: 'bold'
                                    }
                                }
                            },
                            yaxis: {
                                min: -4,
                                max: 5,
                                labels: {
                                    formatter: function(value) {
                                        if (value > 3) {
                                            return "Tinggi";
                                        } else if (value > -2 && value <= 3) {
                                            return "Normal";
                                        } else {
                                            return "Stunting";
                                        }
                                    }
                                },
                                title: {
                                    text: "Stunting Status",
                                    align: 'left',
                                    style: {
                                        fontSize: '12px',
                                        fontWeight: 'bold'
                                    }
                                }
                            },
                            annotations: {
                                xaxis: [{
                                    x: closestCategory,
                                    borderColor: '#71DD37',
                                    strokeDashArray: 5,
                                    strokeWidth: 4,
                                    label: {
                                        borderColor: '#71DD37',
                                        style: {
                                            color: '#fff',
                                            background: '#71DD37'
                                        },
                                        text: 'Usia: ' + ages + ' bulan'
                                    }
                                }],
                                yaxis: [{
                                    y: annotationYPosition,
                                    borderColor: '#FF4560',
                                    strokeDashArray: 10,
                                    label: {
                                        borderColor: '#FF4560',
                                        style: {
                                            color: '#fff',
                                            background: '#FF4560'
                                        },
                                        text: 'Z-Score: ' + zScores
                                    }
                                }]
                            }
                        };

                        var chart = new ApexCharts(document.querySelector("#chartStat"), options);
                        chart.render();
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
