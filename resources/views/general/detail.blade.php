@extends('Layout.main')

@section('content')
    <section class="p-3">
        <h2 class="fw-semibold">Kecamatan di seluruh {{ $kota->name }}</h2>
        <a href="{{ route('kecamatan.create', ['id_kota' => $kota->id]) }}" class="btn btn-primary mb-2 mt-2 btn-sm"> + Tambah
            Data</a>
        <hr />

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Kecamatan</th>
                    <th scope="col">Aksi</th>

                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1;
                @endphp
                @foreach ($kecamatan as $data)
                    <tr>
                        <th scope="row">{{ $counter }}</th>
                        <td>{{ $data->name }}</td>
                        <td>
                            <a href="/{{ $data->id }}/desa" class="btn btn-primary btn-sm">Selengkapnya</a>
                        </td>
                    </tr>
                    @php
                        $counter++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </section>
@endsection
