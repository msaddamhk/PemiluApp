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
                    <div class="col-sm-12 col-md-8 pb-3">
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
                                    <h6>Jumlah Kecamatan</h6>
                                    <h5 class="fw-bold">{{ $getCountKecamatanForKota }} Kecamatan</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 pb-3">
                        <div class="card p-4 h-100 card-dpt">
                            <div class="d-flex align-items-center justify-content-start h-100">
                                <div>
                                    <h6>Jumlah Desa</h6>
                                    <h5 class="fw-bold">{{ $getCountDesaForKota }} Desa</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 pb-3">
                        <div class="card p-4 h-100 card-dpt">
                            <div class="d-flex align-items-center justify-content-start h-100">
                                <div>
                                    <h6>Jumlah Memilih</h6>
                                    <h5 class="fw-bold">{{ $getVotersForKota }} Orang</h5>
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
                        <th>Nama Kecamatan</th>
                        <th>Total DPT</th>
                        <th>Total Memilih</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($getDataTableForKota as $data)
                        <tr>
                            <td class="my-auto">
                                <a href="{{ route('desa.index', [$data['slugKota'], $data['slugKecamatan']]) }}"
                                    class="text-decoration-none text-black">
                                    {{ $data['name'] }}
                                </a>
                            </td>
                            <td>
                                {{ $data['jumlahDptPerkecamatan'] }}
                            </td>
                            <td>
                                {{ $data['jumlahMemilih'] }}
                            </td>
                            <td>
                                <h1 class="fw-bold fs-6 {{ 0 < 50 ? 'text-warning' : 'text-success' }}">
                                    {{ $data['dataPersen'] }}%
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

        @foreach ($getDataDiagramForKota as $item)
            data.labels.push("{{ $item['name'] }}");
            data.datasets[0].data.push({{ $item['jumlahMemilihPerkecamatan'] }});

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
@endsection
