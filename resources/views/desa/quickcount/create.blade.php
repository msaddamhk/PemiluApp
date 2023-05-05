@extends('Layout.main')

@section('content')
    <section class="p-3">
        <form action="
        {{ route('koor.desa.quick_count.store', [$koordesa, $koortps]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Number Votes</label>
                <input type="number" name="number_of_votes" class="
                form-control"
                    value="{{ old('number_of_votes') }}" required>
                @error('number_of_votes')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Total Votes</label>
                <input type="number" name="total_votes" class="form-control" value="{{ old('total_votes') }}" required>
                @error('total_votes')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group row">
                <label for="result_photo" class="col-form-label">Foto</label>
                <div>
                    <input id="result_photo" type="file"
                        class="d-none form-control-file @error('result_photo') is-invalid @enderror" name="result_photo"
                        onchange="previewImage()">

                    <label for="result_photo">
                        <div class="card p-2 mt-2">
                            <img id="frame" style="max-height: 250px" src="{{ asset('upload-image.png') }}"
                                class="img-fluid">
                        </div>
                    </label>

                    @error('result_photo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Submit</button>
        </form>
    </section>
    <script>
        function previewImage() {
            frame.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection
