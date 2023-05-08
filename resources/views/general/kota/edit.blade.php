@extends('Layout.main')

@section('content')
    <section class="p-3">
        <form action="
        {{ route('kota.update', [$koorkota]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $koorkota->name }}" required>
            </div>

            <div class="form-group mt-3">
                <label for="user">User:</label>

                <select id="user" class="form-control @error('user') is-invalid @enderror" name="user" required>
                    <option value="">Pilih Pengelola</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $koorkota->user_id == $user->id ? 'selected' : '' }}>
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
