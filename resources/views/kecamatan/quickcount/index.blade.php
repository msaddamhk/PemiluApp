@extends('Layout.main')

@section('content')
    <section class="p-3">
        <div class="row">
            <div class="col-md-6">
                <h2 class="fw-semibold">Quick Count</h2>
            </div>
            <div class="col-md-6">
                <div class="d-lg-flex justify-content-lg-end">
                    <form
                        action="
                    {{ route('koor.kecamatan.quick_count.index', [$koorkecamatan, $koordesa, $koortps]) }}"
                        method="GET">
                        <div class="d-flex me-2">
                            <input type="text" name="cari"
                                placeholder="Cari Data..."class="search form-control me-2" />
                            <button class="btn btn-search d-flex justify-content-center align-items-center p-0"
                                type="submit">
                                <img src="{{ asset('assets/images/ic_search.svg') }}" width="20px" height="20px" />
                            </button>
                        </div>
                    </form>

                    @if ($quick_count->isEmpty())
                        <a href="
                        {{ route('koor.kecamatan.quick_count.create', [$koorkecamatan, $koordesa, $koortps]) }}"
                            class="btn btn-primary mb-2 mt-2 btn-sm">
                            + Tambah Data
                        </a>
                    @endif

                </div>
            </div>
        </div>

        <hr />

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
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
                        <td>{{ $item->number_of_votes }}</td>
                        <td>{{ $item->total_votes }}</td>
                        <td>
                            <a href="
                            {{ route('koor.kecamatan.quick_count.edit', [$koorkecamatan, $koordesa, $koortps, $item]) }}"
                                class="btn btn-primary mb-2 mt-2 btn-sm">
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
