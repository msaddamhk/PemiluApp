@extends('Layout.main')

@section('content')
    <section class="p-3">

        <div class="row">
            <div class="col-md-6">
                <h2 class="fw-semibold">Data pemilih Tetap di Tps {{ $koortps->name }}</h2>
            </div>

            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    <form action="{{ route('tps.dpt.index', [$koorkota, $koorkecamatan, $koordesa, $koortps]) }}"
                        method="GET">
                        <div class="d-flex me-2">
                            <input type="text" name="cari"
                                placeholder="Cari DPT...."class="search form-control me-2" />
                            <button class="btn btn-search d-flex justify-content-center align-items-center p-0"
                                type="submit">
                                <img src="{{ asset('assets/images/ic_search.svg') }}" width="20px" height="20px" />
                            </button>
                        </div>
                    </form>

                    <a href="{{ route('tps.dpt.create', [$koorkota, $koorkecamatan, $koordesa, $koortps]) }}"
                        class="btn btn-primary mb-2 mt-2 btn-sm">
                        + Tambah Data
                    </a>
                </div>
            </div>
        </div>

        <hr />

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1;
                @endphp

                @if ($dpt->isEmpty())
                    <tr>
                        <td colspan="4" style="text-align: center;">Tidak ada Data</td>
                    </tr>
                @endif
                @foreach ($dpt as $item)
                    <tr>
                        <th scope="row">{{ $counter }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->is_voters ? 'Memilih' : 'Tidak Memilih' }}</td>
                        <td class="d-flex">
                            <a href="
                            {{ route('tps.dpt.edit', [$koorkota, $koorkecamatan, $koordesa, $koortps, $item]) }}"
                                class="btn btn-primary mb-2 mt-2 btn-sm">
                                Update Data
                            </a>

                            <div class="ms-3 my-auto">
                                <form
                                    action="
                                    {{ route('tps.dpt.update_voters', [$koorkota, $koorkecamatan, $koordesa, $koortps, $item]) }}"
                                    method="POST">
                                    @csrf
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_voters"
                                            {{ $item->is_voters ? 'checked' : '' }} onchange="this.form.submit()">
                                        <label class="form-check-label">
                                            {{ $item->is_voters ? 'Memilih' : 'Tidak Memilih' }}</label>
                                    </div>
                                </form>
                            </div>
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
