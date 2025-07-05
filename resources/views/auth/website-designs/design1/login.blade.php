@extends('designs::layout.main')

@section('content')
    <!-- Sign In -->
    <div class="row gx-0">

        <!-- login Content -->
        <div class="col-12">
            <div class="login-wrapper">
                <div class="login-content">
                    <form action="{{route('login')}}" method="POST">
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
                                    <h3>@lang('home.Hi, welcome back again!')</h3>
                                    <p>@lang('home.Please fill in the required fields to log in to your account.')</p>
                                </div>
                                <div class="form-wrap form-focus">
                                    <span class="form-icon">
                                        <i class="feather-mail"></i>
                                    </span>
                                    <input type="text"  name="email" autocomplete="off" class="form-control floating @error('email') is-invalid @enderror" />
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <label class="focus-label">@lang('home.email')</label>
                                </div>

                                <div class="form-wrap form-focus pass-group">
                                    <span class="form-icon">
                                        <i class="toggle-password feather-eye-off"></i>
                                    </span>
                                    <input class="form-control floating pass-input @error('password') is-invalid @enderror" type="password" name="password" autocomplete="off">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <label class="focus-label">@lang('home.password')</label>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-wrap">
                                            <label class="custom_check mb-0">@lang('home.remember_me')
                                                <input type="checkbox" name="remember">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-wrap text-md-end">
                                            <a href="{{ route('password.request') }}" class="forgot-link"> @lang('home.Forgot password?')</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-wrap mantadory-info d-none">
                                    <p><i class="feather-alert-triangle"></i>املأ جميع الحقول لإتمام الإرسال</p>
                                </div>
                                <button type="submit" class="btn btn-primary"> @lang('home.login')</button>
                                <div class="login-or">
                                    <span class="span-or">@lang('home.login with social media chanels')</span>
                                </div>
                                <ul class="login-social-link">
                                    <li>
                                        <a href="{{route('google.login')}}">
                                            <img src="{{ WebsiteHelper::getAsset('img/icons/google-icon.svg')}}" alt="google logo"> @lang('home.Google')
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('facebook.login')}}">
                                            <img src="{{ WebsiteHelper::getAsset('img/icons/fb.svg')}}" alt="facebook logo"> @lang('home.facebook')
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="acc-in">
                                <p>@lang('home.Not a Member yet?')<a href="{{route('register')}}"> @lang('home.Sign up')</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- /Login Content -->

    </div>
    <!-- /Sign In -->
@endsection
