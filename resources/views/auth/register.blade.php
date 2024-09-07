@extends('layouts.AuthLayout')

@section('title', 'Register')

@section('content')
    <div class="auth-form">
        <div class="card my-5">
            <div class="card-body">
                <div class="text-center">
                    <img src="{{ URL::asset('build/images/authentication/img-auth-register.png') }}" alt="images" class="img-fluid mb-3">
                    <h4 class="f-w-500 mb-1">Register with your email</h4>
                    <p class="mb-3">Already have an Account? <a href="{{ route('login') }}" class="link-primary">Log
                            in</a></p>
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                            required autocomplete="new-password" placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" class="form-control" name="password_confirmation" required
                            autocomplete="new-password" placeholder="Confirm Password">
                    </div>
                    <div class="text-center mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="user_type" id="merchant" value="merchant">
                            <label class="form-check-label" for="merchant"> Merchant </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="user_type" id="customer" value="customer">
                            <label class="form-check-label" for="customer"> Customer </label>
                        </div>
                        @error('user_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="merchant-wrapper d-none">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea type="text" class="form-control @error('address') is-invalid @enderror" name="address" autocomplete="address" placeholder="Masukan Alamat Merchant">{{ old('address') }}</textarea>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}" autocomplete="contact" placeholder="Masukan Kontak Merchant">
                                    @error('contact')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <textarea type="text" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" placeholder="Masukan Deskripsi Merchant">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="customer-wrapper d-none">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <textarea type="text" class="form-control @error('address') is-invalid @enderror" name="address" autocomplete="address" placeholder="Masukan Alamat Customer">{{ old('address') }}</textarea>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}" autocomplete="contact" placeholder="Masukan Kontak Customer">
                                    @error('contact')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Create Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#merchant').click(function() {
            $('.merchant-wrapper').removeClass('d-none');
            $('.customer-wrapper').addClass('d-none');
        });

        $('#customer').click(function() {
            $('.merchant-wrapper').addClass('d-none');
            $('.customer-wrapper').removeClass('d-none');
        });

    </script>
@endsection
