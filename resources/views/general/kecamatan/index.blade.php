@extends('Layout.main')

@section('content')
    <section class="p-3">

        <div class="d-lg-flex justify-content-between">
            <h5 class="fw-semibold">Kecamatan di seluruh {{ $koorkota->name }}</h5>
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="bi bi-plus-circle me-1"></i>Tambah Data
            </button>
        </div>

        <div class="card p-3 mt-3">
            <form action="{{ route('kecamatan.index', $koorkota) }}" method="GET">
                <div class="d-flex me-2 mt-2 mb-2">
                    <input type="text" name="cari" value="{{ request('cari') }}"
                        placeholder="Cari Kecamatan..."class="form-control me-2" />
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
                            <th scope="col">Nama Kecamatan</th>
                            <th scope="col">Pengelola</th>
                            <th scope="col">Jumlah Desa</th>
                            <th scope="col">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kecamatan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
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
                                <td>{{ $item->jumlahDesa() }} Desa</td>
                                <td class="d-lg-flex">
                                    <a href="{{ route('desa.index', [$koorkota, $item]) }}" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye-fill me-1"></i>Lihat Desa</a>

                                    <a href="{{ route('kecamatan.edit', [$koorkota, $item]) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square me-1"></i>Update Data
                                    </a>
                                    <a href="{{ route('grafik.kecamatan.index', [$koorkota, $item]) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-graph-up-arrow me-1"></i>Lihat Grafik</a>

                                    <form action="{{ route('kecamatan.delete', [$koorkota, $item]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete"
                                            onclick="return confirm('Apakah Anda yakin untuk menghapus?')">
                                            <i class="bi bi-trash3 me-1"></i>Hapus Data
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center;">Tidak ada Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $kecamatan->links() }}
        </div>
    </section>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" action="{{ route('kecamatan.store', $koorkota) }}" method="POST"
                    novalidate>
                    <div class="modal-body">
                        @csrf
                        <section class="p-3">
                            <label class="form-label">Nama Kecamatan</label>
                            <input type="text" name="name" class="form-control" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="mb-2">
                                <label for="user" class="col-form-label">Pengelola</label>
                                <div>
                                    <select id="user" class="form-control choices @error('user') is-invalid @enderror"
                                        name="user">
                                        <option value="">Pilih Pengelola</option>
                                        @foreach ($user as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('user') == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <small for="exampleInputEmail1" class="fst-italic fw-normal">*Belum ada Data Pengelola ?
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

    @push('scripts')
        @if ($errors->any())
            <script>
                $(document).ready(function() {
                    $('#exampleModal').modal('show');
                });
            </script>
        @endif
    @endpush
@endsection
