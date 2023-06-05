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

                    <div class="col-sm-12 col-md-12 pb-3">
                        <div class="card p-4 h-100">
                            <div class="d-flex align-items-center justify-content-start h-100">
                                <div>
                                    <h6>Countdown</h6>
                                    <h5 id="countingDown" class="fw-bold"></h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 pb-3">
                        <div class="card p-4 h-100 card-dpt">
                            <div class="d-flex align-items-center justify-content-start h-100">
                                <div>
                                    <h6>Jumlah Desa</h6>
                                    <h5 class="fw-bold"> {{ $kecamatan->jumlahDesa() }} Desa</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 pb-3">
                        <div class="card p-4 h-100 card-dpt">
                            <div class="d-flex align-items-center justify-content-start h-100">
                                <div>
                                    <h6>Jumlah Memilih</h6>
                                    <h5 class="fw-bold">{{ $jumlahDpt }} Orang </h5>
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
                        <th>Nama Desa</th>
                        <th>Total DPT</th>
                        <th>Total Memilih</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($desa as $item)
                        <tr>
                            <td class="my-auto">
                                <a href="{{ route('koor.kecamatan.dpt.index', [$kecamatan, $item]) }}"
                                    class="text-decoration-none text-black">
                                    {{ $item->name }}
                                </a>
                            </td>
                            <td>
                                {{ $item->total_dpt ? $item->total_dpt . ' Orang' : '-' }}
                            </td>

                            <td>
                                {{ $item->dpt_is_voters_count ? $item->dpt_is_voters_count . ' Orang' : '-' }}
                            </td>
                            <td>
                                @if ($item->total_dpt && $item->dpt_is_voters_count)
                                    <h1
                                        class="fs-6 fw-bold {{ $item->total_dpt && $item->dpt_is_voters_count && ($item->dpt_is_voters_count / $item->total_dpt) * 100 > 50 ? 'text-success' : 'text-warning' }}">
                                        {{ round(($item->dpt_is_voters_count / $item->total_dpt) * 100, 2) }}%
                                    </h1>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $desa->links() }}
        </div>



    </section>

    <script>
        var data = {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                data: {!! json_encode($data) !!},
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
