@extends('Layout.main')

@section('content')
    <section class="p-3">
        <h5 class="fw-semibold">Dashboard</h5>
        <hr />

        <div class="">
            <img src="{{ asset('bannerdefault.png') }}" width="100%" class="mt-2 mb-4 rounded-3" style="object-fit: cover;"
                alt="" />
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-9">
                <div class="row h-100">
                    <div class="col-sm-12 col-md-4 pb-3">
                        <div class="card p-4 h-100">
                            <div class="d-flex align-items-center justify-content-start h-100">
                                <div>
                                    <h6>Countdown</h6>
                                    <h5 id="countingDown" class="fw-bold"></h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 pb-3">
                        <div class="card p-4 h-100 card-dpt">
                            <div class="d-flex align-items-center justify-content-start h-100">
                                <div>
                                    <h6>Real Count</h6>
                                    <h5 class="fw-bold">100 Orang</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 pb-3">
                        <div class="card p-4 h-100 card-dpt">
                            <div class="d-flex align-items-center justify-content-start h-100">
                                <div>
                                    <h6>Jumlah Kota</h6>
                                    <h3 class="fw-bold">{{ $kotaCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 pb-3">
                        <div class="card p-4 h-100 card-dpt">
                            <div class="d-flex align-items-center justify-content-start h-100">
                                <div>
                                    <h6>Jumlah Kecamatan</h6>
                                    <h3 class="fw-bold">{{ $kecamatanCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 pb-3">
                        <div class="card p-4 h-100 card-dpt">
                            <div class="d-flex align-items-center justify-content-start h-100">
                                <div>
                                    <h6>Jumlah Desa</h6>
                                    <h3 class="fw-bold">{{ $desaCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 pb-3">
                        <div class="card p-4 h-100 card-dpt">
                            <div class="d-flex align-items-center justify-content-start h-100">
                                <div>
                                    <h6>Jumlah DPT Memilih</h6>
                                    <h3 class="fw-bold">{{ $dptCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 pb-3 mt-2 mt-lg-0">
                <div class="card" style="min-height: 300px">
                    <div class="my-auto">
                        <div class="card-body">
                            <canvas id="myChart2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-2 card py-4 px-3 card-dpt">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nama Kota</th>
                        <th>Total DPT</th>
                        <th>Total Memilih</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cityData as $data)
                        <tr>
                            <td class="my-auto">
                                <a href="{{ route('kecamatan.index', $data['slug']) }}"
                                    class="text-decoration-none text-black">
                                    {{ $data['kota'] }}
                                </a>
                            </td>
                            <td>{{ $data['total_penduduk'] }}</td>
                            <td>{{ $data['total_dpt'] }}</td>
                            <td>
                                <h1 class="fw-bold fs-6 {{ $data['persentase'] < 50 ? 'text-warning' : 'text-success' }}">
                                    {{ $data['persentase'] }}%
                                </h1>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </section>

    <script>
        var data = {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [],
                hoverBackgroundColor: []
            }]
        };

        @foreach ($getDataDiagram as $item)
            data.labels.push("{{ $item['name'] }}");
            data.datasets[0].data.push({{ $item['count'] }});

            var color = random_color();
            data.datasets[0].backgroundColor.push(color);
            data.datasets[0].hoverBackgroundColor.push(color);
        @endforeach

        function random_color() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        var options = {
            responsive: true
        };

        var myPieChart = new Chart(document.getElementById("myChart2"), {
            type: 'pie',
            data: data,
            options: options
        });
    </script>

    @push('scripts')
        <script type="text/javascript">
            var countDownDate = new Date("May 14, 2024 23:10:00").getTime();
            var x = setInterval(function() {
                var now = new Date().getTime();
                var distance = countDownDate - now;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById("countingDown").innerHTML = days + " Hari " + hours +
                    " Jam " + minutes + " Menit " + seconds + " Detik";
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("countingDown").innerHTML = "Daftar Sekarang";
                }
            }, 1000);
        </script>
    @endpush
@endsection
