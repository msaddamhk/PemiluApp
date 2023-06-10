@extends('Layout.main')

@section('content')
    <section class="p-3">

        <div class="d-lg-flex justify-content-between">
            <h5 class="fw-semibold">Data TPS di Desa {{ $koordesa->name }}</h5>
        </div>

        <div class="card p-3 mt-3">
            <form action="{{ route('koor.kecamatan.tps.index', [$koorkecamatan, $koordesa]) }}" method="GET">
                <div class="d-flex me-2 mt-2 mb-2">
                    <input type="text" name="cari" placeholder="Cari TPS..."class="form-control me-2" />
                    <button class="btn btn-search d-flex justify-content-center align-items-center p-0" type="submit">
                        <img src="{{ asset('assets/images/ic_search.svg') }}" width="20px" height="20px" />
                    </button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Pengelola</th>
                            <th scope="col">Total DPT</th>
                            <th scope="col">Total DPT Memilih</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $counter = 1;
                        @endphp
                        @if ($tps->isEmpty())
                            <tr>
                                <td colspan="6" style="text-align: center;">Tidak ada Data</td>
                            </tr>
                        @endif
                        @foreach ($tps as $item)
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
                                    {{ $item->total_dpt_by_tps ? $item->total_dpt_by_tps . ' Orang' : '-' }}
                                </td>

                                <td>
                                    {{ $item->dpt_is_voters_count ? $item->dpt_is_voters_count . ' Orang' : '-' }}
                                </td>

                                <td>
                                    <a href="
                                    {{ route('koor.kecamatan.tps.dpt.index', [$koorkecamatan, $koordesa, $item->slug]) }}"
                                        class="btn btn-info btn-sm">
                                        <i class="bi bi-eye-fill me-1"></i>Kelola DPT
                                    </a>

                                    <a href="
                                    {{ route('koor.kecamatan.quick_count.index', [$koorkecamatan, $koordesa, $item->slug]) }}"
                                        class="btn btn-primary mb-2 mt-2 btn-sm">
                                        Real Count
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
            {{ $tps->links() }}
        </div>
    </section>
@endsection
