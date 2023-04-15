@extends('Layout.main')

@section('content')
    <section class="p-3">
        <h2 class="fw-semibold">Seluruh Desa di {{ $kecamatan->name }}</h2>
        <a href="{{ route('desa.create', ['id_kecamatan' => $kecamatan->id]) }}" class="btn btn-primary mb-2 mt-2 btn-sm"> +
            Tambah
            Data</a>
        <hr />

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Desa</th>
                    <th scope="col">Total DPT</th>
                    @if (env('SHOW_ADD_DATA_TPS', false))
                        <th scope="col">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1;
                @endphp
                @foreach ($desa as $data)
                    <tr>
                        <th scope="row">{{ $counter }}</th>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->total_dpt }}</td>
                        <td>
                            @if (env('SHOW_ADD_DATA_TPS', false))
                                <a href="" class="btn btn-primary">Selengkapnya</a>
                            @endif
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
