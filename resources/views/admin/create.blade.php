@extends('Layout.main')


@section('content')
    <div class="container">
        <form method="post" action="{{ route('users.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name" class="col-form-label">Nama</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}" required>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="col-form-label">Email</label>
                <div>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="phone_number" class="col-form-label">Nomor
                    Telepon</label>
                <div>
                    <input id="phone_number" type="number"
                        class="form-control 
                    @error('phone_number') is-invalid @enderror"
                        name="phone_number" value="{{ old('phone_number') }}" required>

                    @error('phone_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="photo" class="col-form-label">Foto Profil</label>

                <div>
                    <input id="photo" type="file"
                        class="d-none form-control-file @error('photo') is-invalid @enderror" name="photo"
                        onchange="previewImage()">

                    <label for="photo">
                        <div class="card p-2 mt-2">
                            <img id="frame" style="max-height: 250px" src="{{ asset('upload-image.png') }}"
                                class="img-fluid">
                        </div>
                    </label>

                    @error('photo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            @if (auth()->user()->level == 'GENERAL')
                <div class="form-group row">
                    <label for="level" class="col-form-label">Level</label>
                    <div>
                        <select id="level" class="form-control @error('level') is-invalid @enderror" name="level">
                            <option value="">Pilih Level</option>
                            <option value="GENERAL" {{ old('level') == 'GENERAL' ? 'selected' : '' }}>General
                            </option>
                            <option value="KOOR_KAB_KOTA" {{ old('level') == 'KOOR_KAB_KOTA' ? 'selected' : '' }}>
                                Koordinator Kab
                            <option value="KOOR_KECAMATAN" {{ old('level') == 'KOOR_KECAMATAN' ? 'selected' : '' }}>
                                Koordinator Kecamatan
                            </option>
                            <option value="KOOR_DESA" {{ old('level') == 'KOOR_DESA' ? 'selected' : '' }}>
                                Koordinator Desa</option>
                            @if (env('SHOW_ADD_DATA_TPS', false))
                                <option value="KOOR_TPS" {{ old('level') == 'KOOR_TPS' ? 'selected' : '' }}>
                                    Koordinator TPS</option>
                            @endif
                        </select>

                        @error('level')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            @endif

            <div class="form-group">
                <label class="col-form-label">Status</label>

                <div class="d-flex">
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio" name="is_active" id="flexRadioDefault1"
                            value="1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Aktif
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_active" id="flexRadioDefault2"
                            value="0">
                        <label class="form-check-label" for="flexRadioDefault2">
                            Tidak Aktif
                        </label>
                    </div>

                </div>
            </div>

            <div class="form-group">
                <label for="password" class="col-form-label">Password</label>
                <div>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="password-confirm" class="col-form-label">Konfirmasi
                    Password</label>
                <div>
                    <input id="
                    password-confirm" type="password" class="form-control"
                        name="password_confirmation" required>
                </div>
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    Batal
                </a>
            </div>

        </form>
    </div>

    <script>
        function previewImage() {
            frame.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection
