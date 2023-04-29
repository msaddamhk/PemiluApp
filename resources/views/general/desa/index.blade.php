@extends('Layout.main')

@section('content')
    <section class="p-3">
        <div class="d-flex justify-content-between">
            <h2 class="fw-semibold">Seluruh Desa di {{ $kecamatan->name }}</h2>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                + Tambah Data
            </button>
        </div>
        <hr />

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
                @if ($kecamatan->koor_desa->isEmpty())
                    <tr>
                        <td colspan="5" style="text-align: center;">Tidak ada Data</td>
                    </tr>
                @endif
                @foreach ($kecamatan->koor_desa as $data)
                    <tr>
                        <th scope="row">{{ $counter }}</th>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->dpt_count }}</td>
                        <td>{{ $data->dpt_is_voters_count }}</td>
                        <td>
                            @if (env('SHOW_ADD_DATA_TPS', false))
                                <a href="{{ route('tps.index', [
                                    'slug_kota' => $kecamatan->kota->slug,
                                    'slug_kecamatan' => $kecamatan->slug,
                                    'slug_desa' => $data->slug,
                                ]) }}"
                                    class="btn btn-primary btn-sm">Kelola TPS</a>
                            @else
                                <a href="{{ route('dpt.index', [
                                    'slug_kota' => $kecamatan->kota->slug,
                                    'slug_kecamatan' => $kecamatan->slug,
                                    'slug_desa' => $data->slug,
                                ]) }}"
                                    class="btn btn-primary btn-sm">Kelola DPT</a>
                            @endif
                        </td>
                    </tr>
                    @php
                        $counter++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </section>

    <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('desa.store', ['id_kecamatan' => $kecamatan->id]) }}" method="POST">
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
    </div>
@endsection
