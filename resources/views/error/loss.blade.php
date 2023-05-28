@extends('Layout.main_error')

@section('content')
    <section class="d-flex align-items-center justify-content-center" style="height: 100vh">
        <div class="container">
            <div class="isi text-center">
                <img src="{{ asset('koneksi-error.png') }}" width="52%" alt="">
                <h2 class="fw-bolder mt-5">KONEKSI TERPUTUS</h2>
                <p>Silakan koneksikan ke internet Anda</p>
            </div>
        </div>
    </section>
@endsection
