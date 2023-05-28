@extends('Layout.main')

@section('content')
    <section class="p-3">

        <h5 class="fw-semibold">Desa</h5>
        <div class="card p-3 mt-3">
            <form action="{{ route('koor.desa.index') }}" method="GET">
                <div class="d-flex me-2 mt-2 mb-2">
                    <input type="text" name="cari" placeholder="Cari Desa..."class="form-control me-2" />
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
                            <th scope="col">Nama Desa</th>
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
                        @if ($desa->isEmpty())
                            <tr>
                                <td colspan="5" style="text-align: center;">Tidak ada Data</td>
                            </tr>
                        @endif

                        @foreach ($desa as $item)
                            <tr>
                                <th scope="row">{{ $counter }}</th>
                                <td>
                                    <a href="{{ route('koor.desa.dpt.index', [$item->slug]) }}" class="text-black">
                                        {{ $item->name }}
                                    </a>
                                </td>
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
                                    {{ $item->total_dpt ? $item->total_dpt . ' Orang' : '-' }}
                                </td>

                                <td>
                                    {{ $item->dpt_is_voters_count ? $item->dpt_is_voters_count . ' Orang' : '-' }}
                                </td>
                                <td>
                                    @if (env('SHOW_ADD_DATA_TPS', false))
                                        <a href="{{ route('koor.desa.tps.index', [$item]) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye-fill me-1"></i>Kelola TPS
                                        </a>

                                        <a href="{{ route('grafik.koodesa.index', [$item]) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="bi bi-graph-up-arrow me-1"></i>Lihat Grafik
                                        </a>
                                    @else
                                        <a href="{{ route('koor.desa.dpt.index', [$item->slug]) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye-fill me-1"></i>Kelola DPT
                                        </a>
                                        <a href="{{ route('koor.desa.desa.quick_count.index', [$item]) }}"
                                            class="btn btn-primary btn-sm">Real Count
                                        </a>
                                    @endif
                                    <a href="{{ route('koor.desa.edit', [$item]) }}" class="btn btn-warning btn-sm">
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
        </div>
    </section>
@endsection
