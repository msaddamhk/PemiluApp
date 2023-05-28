@extends('Layout.main')

@section('content')
    <section class="p-3">
        <div class="d-flex justify-content-between">
            <h5 class="fw-semibold">Kecamatan</h5>
        </div>

        <div class="card p-3 mt-3">
            <form action="{{ route('koor.kecamatan.index') }}" method="GET">
                <div class="d-flex mt-2 mb-2">
                    <input type="text" name="cari" placeholder="Cari Kecamatan..."class="form-control me-2" />
                    <button class="btn btn-search d-flex justify-content-center align-items-center p-0" type="button">
                        <img src="{{ asset('assets/images/ic_search.svg') }}" width="20px" height="20px" />
                    </button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Kecamatan</th>
                            <th scope="col">Pengelola</th>
                            <th scope="col">Jumlah Desa</th>
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
                                <td>{{ $item->jumlahDesa() }} Desa</td>
                                <td>
                                    <a href="{{ route('koor.kecamatan.desa.index', [$item]) }}" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye-fill me-1"></i>Lihat Desa
                                    </a>

                                    <a href="{{ route('koor.kecamatan.edit', [$item]) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square me-1"></i>Update Data
                                    </a>

                                    <a href="{{ route('grafik.koorkecamatan.index', [$item]) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-graph-up-arrow me-1"></i>Lihat Grafik
                                    </a>
                                </td>
                            </tr>
                            @php
                                $counter++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
