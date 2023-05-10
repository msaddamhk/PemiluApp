@extends('Layout.main')

@section('content')
    <section class="p-3">
        <form action="{{ route('koor.kecamatan.dpt.update', [$koorkecamatan, $koordesa, $dpt]) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" value="{{ $dpt->name }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">No Identitas</label>
                <input type="text" name="indentity_number" value="{{ $dpt->indentity_number }}" class="form-control">
                @error('indentity_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="is_voters">Jenis Kelamin</label>
                <div class="d-flex mt-1 mb-2">
                    <div class="form-check me-5">
                        <input class="form-check-input" type="radio" name="gender" id="gender_yes" value="laki-laki"
                            {{ $dpt->gender == 'laki-laki' ? 'checked' : '' }}>
                        <label class="form-check-label" for="gender_yes">
                            Laki-Laki
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender_no" value="perempuan"
                            {{ $dpt->gender == 'perempuan' ? 'checked' : '' }}>
                        <label class="form-check-label" for="gender_no">
                            Perempuan
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="date_of_birth" value="{{ $dpt->date_of_birth }}" class="form-control">
                @error('date_of_birth')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">No Handphone</label>
                <input type="text" name="phone_number" value="{{ $dpt->phone_number }}" class="form-control">
                @error('phone_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_voters">Apakah terdaftar sebagai Pemilih?</label>
                <div class="d-flex mt-1 mb-2">
                    <div class="form-check me-5">
                        <input class="form-check-input" type="radio" name="is_voters" id="is_voters_yes" value="1"
                            {{ $dpt->is_voters == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_voters_yes">
                            Ya
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_voters" id="is_voters_no" value="0"
                            {{ $dpt->is_voters == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_voters_no">
                            Tidak
                        </label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </section>
@endsection
