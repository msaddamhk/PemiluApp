@extends('Layout.main')

@section('content')
    <section class="p-3">
        <form action="{{ route('kecamatan.store', ['id_kota' => $id_kota]) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Kecamatan</label>
                <input type="text" name="name" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </section>
@endsection
