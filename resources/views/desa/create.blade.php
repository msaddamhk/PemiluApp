@extends('Layout.main')

@section('content')
    <section class="p-3">
        <form action="{{ route('desa.store', ['id_kecamatan' => $id_kecamatan]) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Desa</label>
                <input type="text" name="name" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Total DPT</label>
                <input type="text" name="total_dpt" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </section>
@endsection
