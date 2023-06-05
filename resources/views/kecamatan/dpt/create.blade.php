@extends('Layout.main')

@section('content')
    <section class="p-3">
        <form action="{{ route('koor.kecamatan.dpt.store', [$koorkecamatan, $koordesa]) }}" method="POST">
            @csrf
            <div class="mb-2">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            @if (env('SHOW_ADD_DATA_TPS', false))
                <div class="mb-3">
                    <label for="tps" class="col-form-label">TPS</label>
                    <div>
                        <select id="tps" class="form-control choices" name="tps">
                            <option value="">Pilih TPS</option>
                            @foreach ($koordesa->koortps as $data)
                                <option value="{{ $data->id }}">
                                    {{ $data->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label">No Identitas</label>
                <input type="text" name="indentity_number" class="form-control" value="{{ old('indentity_number') }}">
                @error('indentity_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_voters">Jenis Kelamin</label>
                <div class="d-flex mt-1 mb-2">
                    <div class="form-check me-5">
                        <input class="form-check-input" type="radio" name="gender" id="gender_yes" value="laki-laki"
                            {{ old('gender') == 'laki-laki' ? 'checked' : '' }}>
                        <label class="form-check-label" for="gender_yes">
                            Laki-Laki
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender_no" value="perempuan"
                            {{ old('gender') == 'perempuan' ? 'checked' : '' }}>
                        <label class="form-check-label" for="gender_no">
                            Perempuan
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">No Handphone</label>
                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}">
                @error('phone_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </section>
@endsection
