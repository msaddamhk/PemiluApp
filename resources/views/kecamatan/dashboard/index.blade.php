@extends('Layout.main')


@section('content')
    <section class="p-3">
        <h3 class="fw-semibold">Dashboard</h3>
        <hr />

        <div class="">
            <img src="{{ asset('gelora1.png') }}" width="100%" class="mt-2 mb-4 rounded-3" style="object-fit: cover;"
                alt="" />
        </div>


        <div class="row">
            <div class="col-sm-12 col-md-9">
                <div class="row h-100">
                    <div class="col-sm-12 col-md-6 pb-3">
                        <div class="card px-3 px-md-4 h-100 p-2 bg-light border-0">
                            <div class="d-flex align-items-center justify-content-start h-100">
                                <div>
                                    <h4>Jumlah Desa</h4>
                                    <h2 class="fw-bold mb-0">{{ $kecamatan->jumlahDesa() }} Desa</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 pb-3">
                        <div class="card px-3 px-md-4 h-100 p-2 bg-light border-0">
                            <div class="d-flex align-items-center justify-content-start h-100">
                                <div>
                                    <h4>Jumlah DPT</h4>
                                    <h2 class="fw-bold mb-0">{{ $jumlahDpt }} Orang</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 pb-3">
                        <div class="card px-3 px-md-4 h-100 p-2 bg-light border-0">
                            <div class="d-flex align-items-center justify-content-start h-100">
                                <div>
                                    <h4>Jumlah Desa</h4>
                                    <h2 class="fw-bold mb-0">{{ $kecamatan->jumlahDesa() }} Desa</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 pb-3">
                        <div class="card px-3 px-md-4 h-100 p-2 bg-light border-0">123</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 pb-3">
                <div class="card bg-light border-0">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah DPT</h5>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-9 mb-3">
                <div class="card bg-light border-0">
                    <div class="card-body">
                        <h5>Desa</h5>
                        <canvas id="myChartBar3"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-lg-0">
                <div class="card bg-light border-0">
                    <div class="card-body">
                        <h5 class="card-title">Usia</h5>
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
@endsection
