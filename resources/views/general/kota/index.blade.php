@extends('Layout.main')

@section('content')
    <section class="p-3">
        <div class="d-lg-flex justify-content-between">
            <h5 class="fw-semibold">Kabupaten/Kota</h5>
            <div>
                @if (auth()->user()->level == 'GENERAL')
                    <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <small><i class="bi bi-plus-circle me-1"></i>Tambah Data Manual</small>
                    </button>

                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#modalTambahOtomatis">
                        <small><i class="bi bi-plus-circle me-1"></i>Tambah Data Otomatis</small>
                    </button>
                @endif
            </div>
        </div>
        @if (session('error'))
            <div class="alert alert-danger mt-3" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif
        <div class="card p-3 mt-3">
            <form action="{{ route('kota.index') }}" method="GET">
                <div class="d-flex me-2 mb-3 mt-2">
                    <input type="text" name="cari" placeholder="Cari Kab/Kota..." class="form-control me-2" />
                    <button class="btn btn-search d-flex justify-content-center align-items-center p-0" type="submit">
                        <img src="{{ asset('assets/images/ic_search.svg') }}" width="20px" height="20px" />
                    </button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-borderles">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Kabupaten/Kota</th>
                            <th scope="col">Pengelola</th>
                            <th scope="col">Jumlah Kecamatan</th>
                            <th scope="col">Aksi</th>

                        </tr>
                    </thead>

                    <tbody>
                        @if ($kota->isEmpty())
                            <tr>
                                <td colspan="5" style="text-align: center;">Tidak ada Data</td>
                            </tr>
                        @endif
                        @foreach ($kota as $item)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
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
                                    <small>{{ $item->jumlahKecamatan() }} Kecamatan</small>
                                </td>
                                <td class="d-lg-flex">
                                    <a href="{{ route('kecamatan.index', $item) }}" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye-fill me-1"></i>Lihat Kecamatan</a>

                                    <a href="{{ route('kota.edit', $item) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square me-1"></i>Update Data</a>

                                    <a href="{{ route('grafik.kota.index', $item) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-graph-up-arrow me-1"></i>Lihat Grafik</a>

                                    <form action="{{ route('kota.delete', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete"
                                            onclick="return confirm('Apakah Anda yakin untuk menghapus?')">
                                            <i class="bi bi-trash3 me-1"></i>Hapus Data
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if (auth()->user()->level == 'GENERAL')
                {{ $kota->links() }}
            @endif
        </div>
    </section>

    @if (auth()->user()->level == 'GENERAL')
        <div class="modal fade modal1" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="needs-validation" action="{{ route('kota.store') }}" method="POST">
                        <div class="modal-body">
                            @csrf
                            <section class="p-3">
                                <div>
                                    <label class="form-label">Nama Kota</label>
                                    <input type="text" name="name" class="form-control" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-2">
                                    <label for="level" class="col-form-label">Pilih Pengelola</label>
                                    <div>
                                        <select id="user"
                                            class="form-control choices @error('user') is-invalid @enderror" name="user">
                                            <option value="">Pilih Pengelola</option>
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
                                <small for="exampleInputEmail1" class="fst-italic">*Belum ada Data Pengelola ?
                                    <a href="{{ route('users.index') }}">Tambahkan
                                        Sekarang </a>
                                </small>
                            </section>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalTambahOtomatis" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="needs-validation" action="{{ route('kota.store.otomatis') }}" method="POST">
                        <div class="modal-body">
                            @if ($isError)
                                <div class="alert alert-danger" role="alert">
                                    <i class="bi bi-exclamation-triangle"></i> Internet connection required
                                </div>
                            @endif
                            @csrf
                            <section class="p-3">
                                <div class="mb-2">
                                    <label for="level" class="col-form-label">Pengelola Kota</label>
                                    <div class="form-group">
                                        <select id="user_otomatis"
                                            class="form-control choices_user_kota_otomatis @error('user') is-invalid @enderror"
                                            name="user">
                                            <option value="" disabled selected>Pilih Pengelola</option>
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
                                <small for="exampleInputEmail1" class="mb-4 fst-italic fw-normal">*Belum ada Data
                                    Pengelola ?
                                    <a href="{{ route('users.index') }}">Tambahkan
                                        Sekarang </a>
                                </small>
                                <div>
                                    <label for="level" class="col-form-label">Kabupaten/Kota</label>
                                    <div>
                                        <select id="api_kota" class="form-control choices_kota" name="api_kota"
                                            required>
                                            <option value="">Pilih Kab/Kota</option>
                                            @foreach ($filteredData as $item)
                                                <option value="{{ $item['id'] }},{{ $item['nama'] }}">
                                                    {{ $item['nama'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" @disabled($isError) class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

@endsection

@push('scripts')
    <script>
        const choices_user_kota_otomatis = new Choices('#user_otomatis', {
            searchEnabled: true,
            searchChoices: true,
            placeholder: true,
            placeholderValue: 'Pilih pengelola',
        });
    </script>
    <script>
        const choices_kota = new Choices('#api_kota', {
            searchEnabled: true,
            searchChoices: true,
            placeholder: true,
            position: 'bottom',
            placeholderValue: 'Pilih Kota',
        });
    </script>

    @if ($errors->any())
        @if ($errors->has('name_otomatis'))
            <script>
                $(document).ready(function() {
                    $('#modalTambahOtomatis').modal('show');
                });
            </script>
        @else
            <script>
                $(document).ready(function() {
                    $('#exampleModal').modal('show');
                });
            </script>
        @endif
    @endif
@endpush
