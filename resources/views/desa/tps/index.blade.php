@extends('Layout.main')

@section('content')
    <section class="p-3">

        <div class="d-lg-flex justify-content-between">
            <h5 class="fw-semibold">Data TPS di Desa {{ $koordesa->name }}</h5>
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="bi bi-plus-circle me-1"></i>Tambah Data Tps
            </button>
        </div>

        <div class="card p-3 mt-3">
            <form action="{{ route('koor.desa.tps.index', [$koordesa]) }}" method="GET">
                <div class="d-flex me-2 mt-2 mb-2">
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
                        @if ($tps->isEmpty())
                            <tr>
                                <td colspan="6" style="text-align: center;">Tidak ada Data</td>
                            </tr>
                        @endif
                        @foreach ($tps as $item)
                            <tr>
                                <th scope="row">{{ $counter }}</th>
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
                                    {{ $item->total_dpt_by_tps ? $item->total_dpt_by_tps . ' Orang' : '-' }}
                                </td>

                                <td>
                                    {{ $item->dpt_is_voters_count ? $item->dpt_is_voters_count . ' Orang' : '-' }}
                                </td>
                                <td>
                                    <a href="
                                {{ route('koor.desa.tps.dpt.index', [$koordesa, $item]) }}"
                                        class="btn btn-info btn-sm">
                                        <i class="bi bi-eye-fill me-1"></i>Kelola DPT
                                    </a>
                                    <a href="
                                {{ route('koor.desa.quick_count.index', [$koordesa, $item]) }}"
                                        class="btn btn-primary btn-sm">
                                        Real Count
                                    </a>
                                    <a href="
                                {{ route('koor.desa.tps.edit', [$koordesa, $item]) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square me-1"></i>Update Data
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
            {{ $tps->links() }}
        </div>
    </section>


    <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('koor.desa.tps.store', [$koordesa]) }}" method="POST">
                    <div class="modal-body p-4">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Nama TPS</label>
                            <input type="text" name="name" class="form-control" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label">Jumlah DPT</label>
                            <input type="number" name="total_dpt_by_tps" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label for="user" class="col-form-label">Pengelola</label>
                            <div>
                                <select id="user" class="form-control choices @error('user') is-invalid @enderror"
                                    name="user">
                                    <option value="">Pilih Pengelola</option>
                                    @foreach ($user as $data)
                                        <option value="{{ $data->id }}"
                                            {{ old('user') == $data->id ? 'selected' : '' }}>
                                            {{ $data->name }}
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
                        <small for="exampleInputEmail1" class="fst-italic fw-normal">*Belum ada Data Pengelola ?
                            <a href="{{ route('users.index') }}">Tambahkan
                                Sekarang </a>
                        </small>
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
