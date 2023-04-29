@extends('Layout.main')

@section('content')
    <section class="p-3">
        <div class="d-flex justify-content-between">
            <h2 class="fw-semibold">Kabupaten/Kota</h2>
            @if (auth()->user()->level == 'GENERAL')
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    + Tambah Data
                </button>
            @endif
        </div>

        <hr />

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Kabupaten/Kota</th>
                    <th scope="col">Aksi</th>

                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1;
                @endphp
                @if ($kota->isEmpty())
                    <tr>
                        <td colspan="3" style="text-align: center;">Tidak ada Data</td>
                    </tr>
                @endif
                @foreach ($kota as $data)
                    <tr>
                        <th scope="row">{{ $counter }}</th>
                        <td>{{ $data->name }}</td>
                        <td>
                            <a href="{{ route('kecamatan.index', ['slug_kota' => $data->slug]) }}"
                                class="btn btn-primary btn-sm">Lihat Kecamatan</a>
                        </td>
                    </tr>
                    @php
                        $counter++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </section>
    @if (auth()->user()->level == 'GENERAL')
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="needs-validation" action="{{ route('kota.store') }}" method="POST" novalidate>
                        <div class="modal-body">
                            @csrf
                            <section class="p-3">
                                <div>
                                    <label class="form-label">Nama Kota</label>
                                    <input type="text" name="name" class="form-control"
                                        @error('name') is-invalid @enderror required>
                                </div>

                                <div>
                                    <label for="level" class="col-form-label">Pengelola</label>
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
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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
    @endif
@endsection
