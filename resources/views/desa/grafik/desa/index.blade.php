@extends('Layout.main')

@section('content')
    <section class="p-3">
        <h3 class="fw-semibold mb-4">Grafik</h3>
        <div class="rounded-4 border-0">
            <div class="card p-5">
                <div>
                    <h5>TPS</h5>
                    <canvas id="myChartBar1"></canvas>
                </div>
                <small class="fw-light fst-italic mt-2">* Data TPS dengan pemilih paling tinggi pada Desa ini</small>
            </div>
        </div>

    </section>

    <script>
        var labels = {!! json_encode($labels) !!};
        var data = {!! json_encode($data) !!};

        var ctx = document.getElementById('myChartBar1').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Data Mimilih',
                    data: data,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(255, 99, 132, 0.8)',
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
    </script>
@endsection
