@extends('designs::layout.main')

@section('content')

<!-- Forgot Password Content -->
<div class="col-lg-12">
    <div class="login-wrapper">
        <div class="login-content">
            <form method="POST" action="{{ route('password.email') }}">
                <input type="hidden" name="login_type" value="student">
                @csrf
                <div class="login-userset">
                    <div class="login-card">
                        <div class="login-logo">
                            <a href="{{route('website.home')}}">
                                <img src="{{Path::uploadedImage('settings',$settings->logo)}}" alt="{{$settings->alt_logo}}">
                            </a>
                        </div>
                        <div class="login-heading">
                            <h3>@lang('dash.Reset Password')</h3>
                            <p>@lang('dash.Please fill in the required fields to log in to your account.')</p>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="form-wrap form-focus">
                            <span class="form-icon">
                                <i class="feather-mail"></i>
                            </span>
                            <input type="email" class="form-control floating @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <label class="focus-label">@lang('dash.email')</label>
                        </div>
                        <button type="submit" class="btn btn-primary">@lang('dash.Send Password Reset Link')</button>
                    </div>
                    <div class="acc-in">
                        <p>@lang('dash.Already have an Account?') <a href="{{route('login')}}">@lang('dash.login')</a></p>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- /Forgot Password Content -->

@endsection
