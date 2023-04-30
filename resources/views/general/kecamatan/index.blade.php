@extends('Layout.main')

@section('content')
    <section class="p-3">
        <div class="row">
            <div class="col-md-6">
                <h2 class="fw-semibold">Kecamatan di seluruh {{ $kota->name }}</h2>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    <form action="{{ route('kecamatan.index', ['slug_kota' => $kota->slug]) }}" method="GET">
                        <div class="d-flex me-2">
                            <input type="text" name="cari"
                                placeholder="Cari Kecamatan..."class="search form-control me-2" />
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

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Kecamatan</th>
                    <th scope="col">Aksi</th>

                </tr>
            </thead>
            <tbody>
                @if ($kota->KoorKecamatan->isEmpty())
                    <tr>
                        <td colspan="3" style="text-align: center;">Tidak ada Data</td>
                    </tr>
                @endif

                @foreach ($kota->KoorKecamatan as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->name }}</td>
                        <td>
                            <a href="{{ route('desa.index', [
                                'slug_kota' => $kota->slug,
                                'slug_kecamatan' => $data->slug,
                            ]) }}"
                                class="btn btn-primary btn-sm">Lihat Desa</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" action="{{ route('kecamatan.store', ['id_kota' => $kota->id]) }}"
                    method="POST" novalidate>
                    <div class="modal-body">
                        @csrf
                        <section class="p-3">
                            <label class="form-label">Nama Kecamatan</label>
                            <input type="text" name="name" class="form-control" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div>
                                <label for="user" class="col-form-label">Pengelola</label>
                                <div>
                                    <select id="user" class="form-control @error('user') is-invalid @enderror"
                                        name="user" required>
                                        <option value="">Pilih Level</option>
                                        @foreach ($user as $data)
                                            <option value="{{ $data->id }}"
                                                {{ old('user') == $data->id ? 'selected' : '' }}>{{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
@endsection
