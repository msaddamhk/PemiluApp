@extends('Layout.main')

@section('content')
    <section class="p-3">
        <div class="d-flex justify-content-between">
            <h5 class="fw-semibold my-auto">Kelola Pengguna</h5>
            <a href="{{ route('users.create') }}" class="btn btn-primary mb-2 mt-2 btn-sm">
                + Tambah Data
            </a>
        </div>
        <hr />

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Level Akses</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1;
                @endphp

                @if ($users->isEmpty())
                    <tr>
                        <td colspan="4" style="text-align: center;">Tidak ada Data</td>
                    </tr>
                @endif
                @foreach ($users as $data)
                    <tr>
                        <th scope="row">{{ $counter }}</th>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->level }}</td>
                        <td>
                            <a href="{{ route('users.edit', $data) }}" class="btn btn-primary mb-2 mt-2 btn-sm">
                                Update Data
                            </a>
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
