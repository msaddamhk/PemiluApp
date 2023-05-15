@extends('Layout.main')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@section('content')
    <section class="p-3">
        <h3 class="fw-semibold">Dashboard</h3>
        <hr />

        <div class="">
            <img src="{{ asset('gelora1.png') }}" width="100%" class="mt-2 mb-4 rounded-3" style="object-fit: cover;"
                alt="" />
        </div>

        <div class="mt-4">
            <div class="row justify-content-center">
                <div class="col-md-6 mb-4">
                    <div class="card p-4 card-dpt" style="border-color: rgba(255, 206, 86, 1)">
                        <h6>Jumlah Desa</h6>
                        <h5 class="fw-bold">{{ $kecamatan->jumlahDesa() }} Desa</h5>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card p-4 card-dpt" style="border-color: rgba(75, 192, 192, 1)">
                        <h6>Jumlah User</h6>
                        <h5 class="fw-bold">20</h5>
                    </div>
                </div>
                <div class="col-md-6 mb-5">
                    <div class="card p-4 card-dpt" style="border-color: rgba(153, 102, 255, 1)">
                        <h6>Jumlah DPT</h6>
                        <h5 class="fw-bold">{{ $jumlahDpt }} Orang</h5>
                    </div>
                </div>
                <div class="col-md-6 mb-5">
                    <div class="card p-4 card-dpt" style="border-color: rgba(255, 159, 64, 1)">
                        <h6>Countdown</h6>
                        <h5 class="fw-bold">100</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid card-dpt rounded-4 border-0">
            <div class="row mt-5 justify-content-center p-3 p-lg-5">

                <div class="col-md-12 mb-5">
                    <h5>Desa</h5>
                    <canvas id="myChartBar3"></canvas>
                </div>

                <div class="col-md-6 mb-3 mb-lg-0">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah DPT</h5>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Usia</h5>
                            <canvas id="myChart2"></canvas>
                        </div>
                    </div>
                </div>

                <script>
                    var labels = {!! json_encode($labels) !!};
                    var data = {!! json_encode($data) !!};

                    var ctx = document.getElementById('myChartBar3').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Total DPT',
                                data: data,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.8)',
                                    'rgba(54, 162, 235, 0.8)',
                                    'rgba(255, 206, 86, 0.8)',
                                    'rgba(75, 192, 192, 0.8)',
                                    'rgba(153, 102, 255, 0.8)',
                                    'rgba(255, 159, 64, 0.8)',
                                    'rgba(106, 187, 170, 0.8)',
                                    'rgba(176, 102, 173, 0.8)',
                                    'rgba(241, 130, 141, 0.8)',
                                    'rgba(139, 125, 174, 0.8)'
                                ],
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });


                    var data = {
                        labels: ["Perempuan", "Laki-Laki"],
                        datasets: [{
                            data: [{{ $jumlahdptperempuan }}, {{ $jumlahdptlaki }}],
                            backgroundColor: ["#FF6384", "#36A2EB"],
                            hoverBackgroundColor: ["#FF6384", "#36A2EB"]
                        }]
                    };
                    var options = {
                        responsive: true
                    };
                    var myPieChart = new Chart(document.getElementById("myChart"), {
                        type: 'pie',
                        data: data,
                        options: options
                    });


                    var data = {
                        labels: ["Remaja", "Dewasa", "Lansia"],
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

            </div>
        </div>

    </section>
@endsection
