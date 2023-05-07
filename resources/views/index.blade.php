@extends('Layout.main')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@section('content')
    <section class="p-3">
        <h1 class="fw-semibold">Dashboard</h1>
        <p>Manage data for growth</p>

        <hr />

        <img src="d.png" width="100%" height="300px" class="mt-2 mb-4 rounded-3"
            style="object-fit: cover; aspect-ratio: 16/9" alt="" />

        <div class="mt-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card p-4 card-dpt">
                        <h6>Jumlah Kecamatan</h6>
                        <h3 class="fw-bold">90.000</h3>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card p-4 card-dpt">
                        <h6>Jumlah Kota</h6>
                        <h3 class="fw-bold">90.000</h3>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card p-4 card-dpt">
                        <h6>Jumlah Desa</h6>
                        <h3 class="fw-bold">90.000</h3>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card p-4 card-dpt">
                        <h6>Jumlah User</h6>
                        <h3 class="fw-bold">90.000</h3>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div class="card p-4 card-dpt">
                        <h6>Jumlah DPT</h6>
                        <h3 class="fw-bold">90.000</h3>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div class="card p-4 card-dpt">
                        <h6>Countdown</h6>
                        <h3 class="fw-bold">90.000</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-4 my-auto">
                <h5>Kota</h5>
                <canvas id="myChartBar1"></canvas>
                <script>
                    var data = {
                        labels: ["January", "February", "March", "April", "May", "June", "July"],
                        datasets: [{
                            label: "My First Dataset",
                            data: [65, 59, 80, 81, 56, 55, 40],
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.2)",
                                "rgba(54, 162, 235, 0.2)",
                                "rgba(255, 206, 86, 0.2)",
                                "rgba(75, 192, 192, 0.2)",
                                "rgba(153, 102, 255, 0.2)",
                                "rgba(255, 159, 64, 0.2)",
                                "rgba(255, 99, 132, 0.2)"
                            ],
                            borderColor: [
                                "rgba(255, 99, 132, 1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 206, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                                "rgba(153, 102, 255, 1)",
                                "rgba(255, 159, 64, 1)",
                                "rgba(255, 99, 132, 1)"
                            ],
                            borderWidth: 1
                        }]
                    };

                    var options = {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    };

                    var myBarChart = new Chart(document.getElementById("myChartBar1"), {
                        type: 'bar',
                        data: data,
                        options: options
                    });
                </script>
            </div>
            <div class="col-md-4 my-auto">
                <h5>Kecamatan</h5>
                <canvas id="myChartBar2"></canvas>
                <script>
                    var data = {
                        labels: ["January", "February", "March", "April", "May", "June", "July"],
                        datasets: [{
                            label: "My First Dataset",
                            data: [65, 59, 80, 81, 56, 55, 40],
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.2)",
                                "rgba(54, 162, 235, 0.2)",
                                "rgba(255, 206, 86, 0.2)",
                                "rgba(75, 192, 192, 0.2)",
                                "rgba(153, 102, 255, 0.2)",
                                "rgba(255, 159, 64, 0.2)",
                                "rgba(255, 99, 132, 0.2)"
                            ],
                            borderColor: [
                                "rgba(255, 99, 132, 1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 206, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                                "rgba(153, 102, 255, 1)",
                                "rgba(255, 159, 64, 1)",
                                "rgba(255, 99, 132, 1)"
                            ],
                            borderWidth: 1
                        }]
                    };

                    var options = {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    };

                    var myBarChart = new Chart(document.getElementById("myChartBar2"), {
                        type: 'bar',
                        data: data,
                        options: options
                    });
                </script>
            </div>


            <div class="col-md-4">
                <canvas id="myChart"></canvas>
                <script>
                    var data = {
                        labels: ["Red", "Blue", "Yellow"],
                        datasets: [{
                            data: [300, 50, 100],
                            backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"],
                            hoverBackgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"]
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
                </script>
            </div>


            <div class="col-md-8 mt-5">
                <h5>Desa</h5>
                <canvas id="myChartBar3"></canvas>
                <script>
                    var data = {
                        labels: ["January", "February", "March", "April", "May", "June", "July"],
                        datasets: [{
                            label: "My First Dataset",
                            data: [65, 59, 80, 81, 56, 55, 40],
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.2)",
                                "rgba(54, 162, 235, 0.2)",
                                "rgba(255, 206, 86, 0.2)",
                                "rgba(75, 192, 192, 0.2)",
                                "rgba(153, 102, 255, 0.2)",
                                "rgba(255, 159, 64, 0.2)",
                                "rgba(255, 99, 132, 0.2)"
                            ],
                            borderColor: [
                                "rgba(255, 99, 132, 1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 206, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                                "rgba(153, 102, 255, 1)",
                                "rgba(255, 159, 64, 1)",
                                "rgba(255, 99, 132, 1)"
                            ],
                            borderWidth: 1
                        }]
                    };

                    var options = {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    };

                    var myBarChart = new Chart(document.getElementById("myChartBar3"), {
                        type: 'bar',
                        data: data,
                        options: options
                    });
                </script>
            </div>
            <div class="col-md-4 mt-5 my-auto">
                <canvas id="myChart2"></canvas>
                <script>
                    var data = {
                        labels: ["Red", "Blue", "Yellow"],
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
