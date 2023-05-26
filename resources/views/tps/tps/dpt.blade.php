@extends('Layout.main')

@section('content')
    <section class="p-3">

        <div class="d-lg-flex justify-content-between">
            <h5 class="fw-semibold">Data pemilih Tetap di {{ $koortps->name }}</h5>
            <a href="{{ route('koor.tps.dpt.create', [$koortps]) }}" class="btn btn-primary mb-2 mt-2 btn-sm">
                + Tambah Data
            </a>
        </div>

        <div class="card p-3 mt-3">
            <form action="{{ route('koor.tps.dpt.index', [$koortps]) }}" method="GET">
                <div class="d-flex me-2 mt-2 mb-2">
                    <input type="text" name="cari" placeholder="Cari DPT...."class="form-control me-2" />
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
                            <th scope="col">Tanggal Lahir</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">No Identitas</th>
                            <th scope="col">No Hp</th>
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
                                <td colspan="8" style="text-align: center;">Tidak ada Data</td>
                            </tr>
                        @endif
                        @foreach ($dpt as $item)
                            <tr>
                                <th scope="row">{{ $counter }}</th>
                                <td>{{ $item->name ?? '-' }}</td>
                                <td>{{ $item->date_of_birth ?? '-' }}</td>
                                <td>{{ $item->gender ?? '-' }}</td>
                                <td>{{ $item->indentity_number ?? '-' }}</td>
                                <td>{{ $item->phone_number ?? '-' }}</td>
                                <td>{{ $item->is_voters ? 'Memilih' : 'Tidak Memilih' }}</td>
                                <td class="d-flex">
                                    <a href="
                                {{ route('koor.tps.dpt.edit', [$koortps, $item]) }}"
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
            {{ $dpt->links() }}
        </div>
    </section>
@endsection
