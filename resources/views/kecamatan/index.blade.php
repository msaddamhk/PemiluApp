@extends('Layout.main')

@section('content')
    <section class="p-3">
        <div class="d-flex justify-content-between">
            <h2 class="fw-semibold">Kecamatan</h2>
            <form action="{{ route('koor.kecamatan.index') }}" method="GET">
                <div class="d-flex">
                    <input type="text" name="cari" placeholder="Cari Kecamatan..."class="search form-control" />
                    <button class="btn btn-search d-flex justify-content-center align-items-center p-0" type="button">
                        <img src="assets/images/ic_search.svg" width="20px" height="20px" />
                    </button>
                </div>
            </form>
        </div>
        <hr />

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Kecamatan</th>
                    <th scope="col">Pengelola</th>
                    <th scope="col">Aksi</th>

                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1;
                @endphp
                @if ($kecamatan->isEmpty())
                    <tr>
                        <td colspan="3" style="text-align: center;">Tidak ada Data</td>
                    </tr>
                @endif
                @foreach ($kecamatan as $item)
                    <tr>
                        <th scope="row">{{ $counter }}</th>
                        <td>{{ $item->name }}</td>
                        <td>
                            @if ($item->user_id == null)
                                <span class="badge text-bg-warning">
                                    <i class="bi bi-exclamation-circle"></i>
                                    Belum ada Pengelola
                                </span>
                            @else
                                {{ $item->user->name }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('koor.kecamatan.desa.index', [$item]) }}" class="btn btn-primary btn-sm">Lihat
                                Desa</a>

                            <a href="{{ route('koor.kecamatan.edit', [$item]) }}" class="btn btn-primary btn-sm">Update
                                Data</a>
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
