@extends('Layout.main')

@section('content')
    <section class="p-3">
        <form action="{{ route('koor.desa.tps.dpt.store', [$koordesa, $koortps]) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

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

            <div class="form-group">
                <label for="is_voters">Apakah terdaftar sebagai Pemilih?</label>
                <div class="d-flex mt-1 mb-2">
                    <div class="form-check me-5">
                        <input class="form-check-input" type="radio" name="is_voters" id="is_voters_yes" value="1"
                            {{ old('is_voters') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_voters_yes">
                            Memilih
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_voters" id="is_voters_no" value="0"
                            {{ old('is_voters') == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_voters_no">
                            Tidak Memilih
                        </label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </section>
@endsection
