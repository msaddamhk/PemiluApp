@extends('Layout.main')

@section('content')
    <section class="p-3">
        <form action="
        {{ route('koor.desa.update', [$koordesa]) }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Nama Desa</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $koordesa->name }}" required>
            </div>

            <div class="form-group">
                <label for="name">Total DPT</label>
                <input type="text" name="total_dpt" id="total_dpt" class="form-control"
                    value="{{ $koordesa->total_dpt }}" required>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Submit</button>

        </form>
    </section>
@endsection
