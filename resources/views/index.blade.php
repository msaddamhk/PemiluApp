@extends('Layout.main')

@section('content')
    <section class="p-3">
        <h1 class="fw-semibold">Dashboard</h1>
        <p>Manage data for growth</p>

        <hr />

        <img src="d.png" width="100%" height="300px" class="mt-2 mb-4 rounded-3"
            style="object-fit: cover; aspect-ratio: 16/9" alt="" />
        <button id="myButton" class="btn-full-screen p-2 btn btn-outline-primary rounded-0 btn-sm">
            <i class="bi bi-fullscreen"></i> Full Screen
        </button>

        <div class="mt-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="card p-4 card-dpt">
                        <h6>Lorem ipsum dolor</h6>
                        <h3 class="fw-bold">90.000</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 card-dpt">
                        <h6>Lorem ipsum dolor</h6>
                        <h3 class="fw-bold">90.000</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 card-dpt">
                        <h6>Lorem ipsum dolor</h6>
                        <h3 class="fw-bold">90.000</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="col-md-12">
                <canvas id="chart-revenue" width="100%"></canvas>
            </div>
        </div>
    </section>
@endsection
