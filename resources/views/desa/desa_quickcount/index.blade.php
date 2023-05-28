@extends('Layout.main')

@section('content')
    <section class="p-3">

        <div class="d-lg-flex justify-content-between">
            <h5 class="fw-semibold">Real Count</h5>
            <a href="
                {{ route('koor.desa.desa.quick_count.create', [$koordesa]) }}"
                class="btn btn-success mb-2 mt-2 btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Tambah Data
            </a>
        </div>

        <div class="card p-3 mt-3">
            <form action="
            {{ route('koor.desa.desa.quick_count.index', [$koordesa]) }}" method="GET">
                <div class="d-flex me-2">
                    <input type="text" name="cari" placeholder="Cari Data..."class="form-control me-2" />
                    <button class="btn btn-search d-flex justify-content-center align-items-center p-0" type="submit">
                        <img src="{{ asset('assets/images/ic_search.svg') }}" width="20px" height="20px" />
                    </button>
                </div>
            </form>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama TPS</th>
                        <th scope="col">Number Vote</th>
                        <th scope="col">Total Vote</th>
                        <th scope="col">Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    @php
                        $counter = 1;
                    @endphp
                    @if ($quick_count->isEmpty())
                        <tr>
                            <td colspan="4" style="text-align: center;">Tidak ada Data</td>
                        </tr>
                    @endif
                    @foreach ($quick_count as $item)
                        <tr>
                            <th scope="row">{{ $counter }}</th>
                            <td>{{ $item->name_tps }}</td>
                            <td>{{ $item->number_of_votes }}</td>
                            <td>{{ $item->total_votes }}</td>
                            <td>
                                <a href="
                            {{ route('koor.desa.desa.quick_count.edit', [$koordesa, $item]) }}"
                                    class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square me-1"></i>Update Data
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
    </section>
@endsection
