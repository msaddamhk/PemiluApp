@extends('Layout.main')

@section('content')
    <section class="p-3">
        <form action="{{ route('koor.kecamatan.dpt.store', ['id_desa' => $desa->id]) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">No Identitas</label>
                <input type="text" name="indentity_number" class="form-control" required>
                @error('indentity_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">No Handphone</label>
                <input type="text" name="phone_number" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="is_voters">Apakah terdaftar sebagai Pemilih?</label>
                <div class="d-flex mt-1 mb-2">
                    <div class="form-check me-5">
                        <input class="form-check-input" type="radio" name="is_voters" id="is_voters_yes" value="1"
                            required>
                        <label class="form-check-label" for="is_voters_yes">
                            Memilih
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_voters" id="is_voters_no" value="0"
                            required>
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
