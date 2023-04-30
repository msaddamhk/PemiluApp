@extends('Layout.main')

@section('content')
    <section class="p-3">
        <div class="row">
            <div class="col-md-6">
                <h2 class="fw-semibold">Desa</h2>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    <form action="{{ route('koor.desa.index') }}" method="GET">
                        <div class="d-flex me-2">
                            <input type="text" name="cari"
                                placeholder="Cari Desa..."class="search form-control me-2" />
                            <button class="btn btn-search d-flex justify-content-center align-items-center p-0"
                                type="submit">
                                <img src="{{ asset('assets/images/ic_search.svg') }}" width="20px" height="20px" />
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr />
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Desa</th>
                        <th scope="col">Total DPT</th>
                        <th scope="col">Total DPT Memilih</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $counter = 1;
                    @endphp
                    @if ($desa->isEmpty())
                        <tr>
                            <td colspan="5" style="text-align: center;">Tidak ada Data</td>
                        </tr>
                    @endif

                    @foreach ($desa as $data)
                        <tr>
                            <th scope="row">{{ $counter }}</th>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->dpt_count }}</td>
                            <td>{{ $data->dpt_is_voters_count }}</td>
                            <td>
                                @if (env('SHOW_ADD_DATA_TPS', false))
                                    <a href="{{ route('koor.desa.tps.index', [
                                        'slug_desa' => $data->slug,
                                    ]) }}"
                                        class="btn btn-primary btn-sm">Kelola TPS</a>
                                @else
                                    <a href="{{ route('koor.desa.dpt.index', [
                                        'slug_desa' => $data->slug,
                                    ]) }}"
                                        class="btn btn-primary btn-sm"><small>Kelola DPT</small></a>
                                @endif
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
