@extends('Layout.main')

@section('content')
    <section class="p-3">
        <h1 class="fw-semibold">Kelola Kab/Kota</h1>
        <a href="{{ route('kota.create') }}" class="btn btn-primary mb-2 mt-2 btn-sm"> + Tambah Data</a>

        <hr />

        <button id="myButton" class="btn-full-screen p-2 btn btn-outline-primary rounded-0 btn-sm">
            <i class="bi bi-fullscreen"></i> Full Screen
        </button>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Kabupaten/Kota</th>
                    <th scope="col">Aksi</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($kota as $data)
                    <tr>
                        <th scope="row">1</th>
                        <td>{{ $data->name }}</td>
                        <td>Otto</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection
