@extends('Layout.main')

@section('content')
    <section class="p-3">
        <form action="
        {{ route('koor.kecamatan.update', [$koorkecamatan]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name" class="mb-3">Nama Kecamatan</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $koorkecamatan->name }}"
                    required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>
    </section>
@endsection
