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
                        action="{{ route('quick_count.index', [
                            'slug_kota' => $tps->KoorDesa->kecamatan->kota->slug,
                            'slug_kecamatan' => $tps->KoorDesa->kecamatan->slug,
                            'slug_desa' => $tps->KoorDesa->slug,
                            'slug_tps' => $tps->slug,
                        ]) }}"
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

                    <a href="{{ route('quick_count.create', [
                        'slug_kota' => $tps->KoorDesa->kecamatan->kota->slug,
                        'slug_kecamatan' => $tps->KoorDesa->kecamatan->slug,
                        'slug_desa' => $tps->KoorDesa->slug,
                        'slug_tps' => $tps->slug,
                    ]) }}"
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
                    <th scope="col">Number Vote</th>
                    <th scope="col">Total Vote</th>
                    <th scope="col">Aksi</th>

                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1;
                @endphp
                @if ($tps->quickCount->isEmpty())
                    <tr>
                        <td colspan="4" style="text-align: center;">Tidak ada Data</td>
                    </tr>
                @endif
                @foreach ($tps->quickCount as $data)
                    <tr>
                        <th scope="row">{{ $counter }}</th>
                        <td>{{ $data->number_of_votes }}</td>
                        <td>{{ $data->total_votes }}</td>
                        <td>
                            <a href="{{ route('quick_count.edit', [
                                'slug_kota' => $tps->KoorDesa->kecamatan->kota->slug,
                                'slug_kecamatan' => $tps->KoorDesa->kecamatan->slug,
                                'slug_desa' => $tps->KoorDesa->slug,
                                'slug_tps' => $tps->slug,
                                'id_quick_count' => $data->id,
                            ]) }}"
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
