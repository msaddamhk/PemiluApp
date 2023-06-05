@extends('layouts.app')

@section('content')
    <section class="vh-100" style="background-color: #f8f9fd;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5 text-center">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5">
                            <h3 class="mb-5">Sign in</h3>

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                    <strong> {{ session('error') }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-floating mb-4">
                                    <input id="email" type="email"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        placeholder="Enter Email" name="email" value="{{ old('email') }}" required
                                        autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <label class="form-label" for="email">{{ __('Email Address') }}</label>
                                </div>

                                <div class="form-floating mb-4">
                                    <input type="password" id="password" placeholder="Enter password"
                                        class="form-control form-control-lg" name="password" required
                                        autocomplete="current-password" />
                                    <label for="password">{{ __('Password') }}</label>
                                </div>

                                <!-- Checkbox -->
                                <div class="form-check d-flex justify-content-start mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    {{ __('Login') }}
                                </button>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
