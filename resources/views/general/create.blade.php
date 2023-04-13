@extends('Layout.main')

@section('content')
    <section class="p-3">
        <form action="{{ route('kota.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Kota</label>
                <input type="text" name="name" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </section>
@endsection
