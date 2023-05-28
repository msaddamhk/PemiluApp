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

            <div class="form-group mt-3">
                <label for="user">User</label>

                <select id="user" class="form-control choices @error('user') is-invalid @enderror" name="user">
                    <option value="">Pilih Pengelola</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $koordesa->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Submit</button>

        </form>
    </section>
@endsection
