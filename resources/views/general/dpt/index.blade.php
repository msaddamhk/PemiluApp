@extends('Layout.main')

@section('content')
    <section class="p-3">
        <div class="d-lg-flex justify-content-between">
            <h5 class="fw-semibold">Data pemilih Tetap di Desa {{ $koordesa->name }}</h5>
            <div>
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="bi bi-file-earmark-arrow-down me-1"></i>Import DPT
                </button>
                <a href="{{ route('dpt.create', [$koorkota, $koorkecamatan, $koordesa]) }}"
                    class="btn btn-success mb-2 mt-2 btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Data
                </a>
            </div>
        </div>



        <div class="card p-3 mt-3">
            <form action="{{ route('dpt.index', [$koorkota, $koorkecamatan, $koordesa]) }}" method="GET">
                <div class="d-flex me-2 mb-2 mt-2">
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
                            @if (env('SHOW_ADD_DATA_TPS', false))
                                <th scope="col">Nama TPS</th>
                            @endif
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
                                <td>{{ $item->name }}</td>
                                @if (env('SHOW_ADD_DATA_TPS', false))
                                    <td>{{ $item->koorTps?->name ?? '-' }}</td>
                                @endif
                                <td>{{ $item->date_of_birth ?? '-' }}</td>
                                <td>{{ $item->gender ?? '-' }}</td>
                                <td>{{ $item->indentity_number ?? '-' }}</td>
                                <td>{{ $item->phone_number ?? '-' }}</td>
                                <td>{{ $item->is_voters ? 'Memilih' : 'Tidak Memilih' }}</td>
                                <td class="d-lg-flex">
                                    <a href="{{ route('dpt.edit', [$koorkota, $koorkecamatan, $koordesa, $item]) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square me-1"></i>Update Data
                                    </a>
                                    <form action="{{ route('dpt.delete', [$koorkota, $koorkecamatan, $koordesa, $item]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete"
                                            onclick="return confirm('Apakah Anda yakin untuk menghapus?')">
                                            <i class="bi bi-trash3 me-1"></i>Hapus Data
                                        </button>
                                    </form>
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

    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('dpt.import', [$koorkota, $koorkecamatan, $koordesa]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="excel_file">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
