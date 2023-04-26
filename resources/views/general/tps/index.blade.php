@extends('Layout.main')

@section('content')
    <section class="p-3">
        <div class="d-flex justify-content-between">
            <h2 class="fw-semibold">Data TPS di Desa {{ $desa->name }}</h2>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                + Tambah Data
            </button>
        </div>
        <hr />

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1;
                @endphp
                @if ($desa->tps->isEmpty())
                    <tr>
                        <td colspan="2" style="text-align: center;">Tidak ada Data</td>
                    </tr>
                @endif
                @foreach ($desa->tps as $data)
                    <tr>
                        <th scope="row">{{ $counter }}</th>
                        <td>{{ $data->name }}</td>
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

                <form action="{{ route('tps.store', ['id_desa' => $desa->id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama TPS</label>
                        <input type="text" name="name" class="form-control" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
