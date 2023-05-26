@extends('Layout.main')

@section('content')
    <section class="p-3">
        <form action="{{ route('koor.kecamatan.desa.quick_count.update', [$koorkecamatan, $koordesa, $quickcount]) }}"
            method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-2">
                <label class="form-label">Nama TPS</label>
                <input type="text" name="name_tps" class="
                form-control" value="{{ $quickcount->name_tps }}"
                    required>
                @error('name_tps')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-2">
                <label class="form-label">Number Votes</label>
                <input type="number" name="number_of_votes" class="
                form-control"
                    value="{{ $quickcount->number_of_votes }}" required>
                @error('number_of_votes')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-2">
                <label class="form-label">Total Votes</label>
                <input type="number" name="total_votes" class="form-control" value="{{ $quickcount->total_votes }}"
                    required>
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
                            <img id="frame"
                                src="{{ $quickcount->result_photo
                                    ? asset('storage/img/quick_count/' . $quickcount->result_photo)
                                    : asset('upload-image.png') }}"
                                class="img-fluid" style="max-height: 250px">
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
