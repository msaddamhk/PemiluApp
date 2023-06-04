@extends('Layout.main')

@section('content')
    <section class="p-3">
        <h3 class="fw-semibold">Dashboarad</h3>
        <hr />

        <div class="">
            <img src="{{ asset('bannerdefault.png') }}" width="100%" class="mt-2 mb-4 rounded-3" style="object-fit: cover;"
                alt="" />
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nama Kota</th>
                    <th>Total DPT</th>
                    <th>Total Penduduk</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cityData as $data)
                    <tr>
                        <td>
                            <a href="{{ route('kecamatan.index', $data['slug']) }}">
                                {{ $data['kota'] }}
                            </a>
                        </td>
                        <td>{{ $data['total_dpt'] }}</td>
                        <td>{{ $data['total_penduduk'] }}</td>
                        <td>{{ $data['persentase'] }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        <div class="row">
            <div class="col-sm-12 col-md-9">
                <div class="row h-100">
                    <div class="col-sm-12 col-md-8 pb-3">
                        <div class="card p-4 h-100" style="border-color: rgba(255, 159, 64, 1)">
                            <div class="d-flex align-items-center justify-content-start h-100">
                                <div>
                                    <h6>Countdown</h6>
                                    <h5 id="countingDown" class="fw-bold"></h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 pb-3">
                        <div class="card p-4 h-100 card-dpt" style="border-color: rgba(255, 99, 132, 1)">
                            <div class="d-flex align-items-center justify-content-start h-100">
                                <div>
                                    <h6>Jumlah Kota</h6>
                                    <h3 class="fw-bold">{{ $kotaCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 pb-3">
                        <div class="card p-4 h-100 card-dpt" style="border-color: rgba(54, 162, 235, 1)">
                            <div class="d-flex align-items-center justify-content-start h-100">
                                <div>
                                    <h6>Jumlah Kecamatan</h6>
                                    <h3 class="fw-bold">{{ $kecamatanCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 pb-3">
                        <div class="card p-4 h-100 card-dpt" style="border-color: rgba(255, 206, 86, 1)">
                            <div class="d-flex align-items-center justify-content-start h-100">
                                <div>
                                    <h6>Jumlah Desa</h6>
                                    <h3 class="fw-bold">{{ $desaCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 pb-3">
                        <div class="card p-4 h-100 card-dpt" style="border-color: rgba(153, 102, 255, 1)">
                            <div class="d-flex align-items-center justify-content-start h-100">
                                <div>
                                    <h6>Jumlah Memilih</h6>
                                    <h3 class="fw-bold">{{ $dptCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 pb-3">
                <div class="card" style="height: 300px">
                    <div class="my-auto">
                        <div class="card-body">
                            <canvas id="myChart2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <script>
        var data = {
            labels: ["Banda Aceh", "Sabang", "Aceh Besar"],
            datasets: [{
                data: [300, 50, 100],
                backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"],
                hoverBackgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"]
            }]
        };
        var options = {
            responsive: true
        };
        var myPieChart = new Chart(document.getElementById("myChart2"), {
            type: 'pie',
            data: data,
            options: options
        });
    </script>
@endsection
