@extends('Layout.main')

@section('content')
    <section class="p-3">

        <h5 class="fw-semibold">TPS</h5>

        <div class="card p-3 mt-3">
            <form action="{{ route('koor.tps.index') }}" method="GET">
                <div class="d-flex me-2 mb-2 mt-2">
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
                            <th scope="col">Total DPT</th>
                            <th scope="col">Total DPT Memilih</th>
                            <th scope="col">Pengelola</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $counter = 1;
                        @endphp
                        @if ($tps->isEmpty())
                            <tr>
                                <td colspan="5" style="text-align: center;">Tidak ada Data</td>
                            </tr>
                        @endif
                        @foreach ($tps as $item)
                            <tr>
                                <th scope="row">{{ $counter }}</th>
                                <td>{{ $item->name }}</td>
                                <td>
                                    @if ($item->total_dpt_by_tps == null)
                                        -
                                    @else
                                        {{ $item->total_dpt_by_tps }} Orang
                                    @endif
                                </td>

                                <td>
                                    @if ($item->dpt_is_voters_count == 0)
                                        -
                                    @else
                                        {{ $item->dpt_is_voters_count }} Orang
                                    @endif
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
                                    <a href="
                                {{ route('koor.tps.dpt.index', [$item]) }}"
                                        class="btn btn-primary mb-2 mt-2 btn-sm">
                                        Kelola DPT
                                    </a>
                                    <a href="
                                    {{ route('koor.tps.quick_count.index', [$item]) }}"
                                        class="btn btn-primary mb-2 mt-2 btn-sm">
                                        Real Count
                                    </a>
                                    <a href="
                                {{ route('koor.tps.edit', [$item]) }}"
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
            </div>
        </div>
    </section>
@endsection
