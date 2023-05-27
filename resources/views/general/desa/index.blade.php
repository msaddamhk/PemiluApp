@extends('Layout.main')

@section('content')
    <section class="p-3">

        <div class="d-flex justify-content-between">
            <h5 class="fw-semibold">Seluruh Desa di {{ $koorkecamatan->name }}</h5>
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="bi bi-plus-circle me-1"></i>Tambah Data
            </button>
        </div>

        <div class="card p-3 mt-3">
            <form action="{{ route('desa.index', [$koorkota, $koorkecamatan]) }}" method="GET">
                <div class="d-flex me-2 mb-2 mt-2">
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
                                <td colspan="6" style="text-align: center;">Tidak ada Data</td>
                            </tr>
                        @endif

                        @foreach ($desa as $item)
                            <tr>
                                <th scope="row">{{ $counter }}</th>
                                <td>
                                    <a class="text-black"
                                        href="{{ route('dpt.index', [$koorkota, $koorkecamatan, $item->slug]) }}">
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
                                        <a href="{{ route('tps.index', [$koorkota, $koorkecamatan, $item->slug]) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="bi bi-eye-fill me-1"></i>Kelola TPS
                                        </a>

                                        <a href="{{ route('grafik.desa.index', [$koorkota, $koorkecamatan, $item]) }}"
                                            class="btn btn-primary btn-sm"><small>
                                                <i class="bi bi-graph-up-arrow me-1"></i>Lihat Grafik</small>
                                        </a>
                                    @else
                                        <a href="{{ route('dpt.index', [$koorkota, $koorkecamatan, $item->slug]) }}"
                                            class="btn btn-info btn-sm"><small>
                                                <i class="bi bi-eye-fill me-1"></i>Kelola DPT</small>
                                        </a>

                                        <a href="{{ route('desa.quick_count.index', [$koorkota, $koorkecamatan, $item->slug]) }}"
                                            class="btn btn-primary btn-sm"><small>Real Count</small></a>
                                    @endif

                                    <a href="{{ route('desa.edit', [$koorkota, $koorkecamatan, $item]) }}"
                                        class="btn btn-warning btn-sm"><small>
                                            <i class="bi bi-pencil-square me-1"></i>Update Data</small>
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
            {{ $desa->links() }}
        </div>
    </section>

    <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('desa.store', [$koorkota, $koorkecamatan]) }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <section class="p-3">
                            <div class="mb-2">
                                <label class="form-label">Nama Desa</label>
                                <input type="text" name="name" class="form-control" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">Total DPT</label>
                                <input type="number" name="total_dpt" class="form-control" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="user" class="col-form-label">Pengelola</label>
                                <div>
                                    <select id="user" class="form-control choices @error('user') is-invalid @enderror"
                                        name="user">
                                        <option value="">Pilih Pengelola</option>
                                        @foreach ($user as $data)
                                            <option value="{{ $data->id }}"
                                                {{ old('user') == $data->id ? 'selected' : '' }}>{{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
