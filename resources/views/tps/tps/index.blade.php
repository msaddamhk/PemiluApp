@extends('Layout.main')

@section('content')
    <section class="p-3">

        <div class="row">
            <div class="col-md-6">
                <h2 class="fw-semibold">TPS</h2>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    <form action="{{ route('koor.tps.index') }}" method="GET">
                        <div class="d-flex me-2">
                            <input type="text" name="cari" placeholder="Cari TPS..."class="search form-control me-2" />
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

        <table class="table table-striped">
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
                        <td>{{ $item->dpt_count }}</td>
                        <td>{{ $item->dpt_is_voters_count }}</td>
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
                                Kelola Quick Count
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
    </section>
@endsection
