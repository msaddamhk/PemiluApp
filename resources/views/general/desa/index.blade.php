@extends('Layout.main')

@section('content')
    <section class="p-3">
        <div class="row">
            <div class="col-md-6">
                <h2 class="fw-semibold">Seluruh Desa di {{ $koorkecamatan->name }}</h2>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    <form action="{{ route('desa.index', [$koorkota, $koorkecamatan]) }}" method="GET">

                        <div class="d-flex me-2">
                            <input type="text" name="cari"
                                placeholder="Cari Desa..."class="search form-control me-2" />
                            <button class="btn btn-search d-flex justify-content-center align-items-center p-0"
                                type="submit">
                                <img src="{{ asset('assets/images/ic_search.svg') }}" width="20px" height="20px" />
                            </button>
                        </div>
                    </form>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        + Tambah Data
                    </button>
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
                        <th scope="col">Pengelola</th>
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
                                @if (env('SHOW_ADD_DATA_TPS', false))
                                    <a href="{{ route('tps.index', [$koorkota, $koorkecamatan, $item->slug]) }}"
                                        class="btn btn-primary btn-sm">Kelola TPS</a>
                                @else
                                    <a href="{{ route('dpt.index', [$koorkota, $koorkecamatan, $item->slug]) }}"
                                        class="btn btn-primary btn-sm"><small>Kelola DPT</small></a>
                                @endif
                                <a href="{{ route('desa.edit', [$koorkota, $koorkecamatan, $item]) }}"
                                    class="btn btn-primary btn-sm"><small>Update Data</small></a>
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
                            <div class="mb-3">
                                <label class="form-label">Nama Desa</label>
                                <input type="text" name="name" class="form-control" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="user" class="col-form-label">Pengelola</label>
                                <div>
                                    <select id="user" class="form-control @error('user') is-invalid @enderror"
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
