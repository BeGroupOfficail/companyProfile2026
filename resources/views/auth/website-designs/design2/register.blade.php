@extends('designs::layout.main')
@section('content')

    <!-- Sign Up -->
    <div class="row gx-0">

        <!-- Register Content -->
        <div class="col-12">
            <div class="login-wrapper reg">
                <div class="login-content">
                    <form action="{{route('register')}}" method="POST">
                        @csrf
                        <input type="hidden" name="register_type" value="student">
                        <div class="login-userset">
                            <div class="login-card">
                                <div class="login-logo">
                                    <a href="{{route('website.home')}}">
                                        <img src="{{Path::uploadedImage('settings',$settings->logo)}}" alt="{{$settings->alt_logo}}">
                                    </a>
                                </div>
                                <div class="login-heading">
                                    <h3>@lang('home.Hi, welcome!')</h3>
                                    <p>@lang('home.Please fill in the required fields to create your account.')</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-wrap form-focus">
                                    <span class="form-icon">
                                        <i class="feather-user"></i>
                                    </span>
                                        <input id="f_name" type="text"  class="form-control floating @error('f_name') is-invalid @enderror" name="f_name" value="{{ old('f_name') }}" required autocomplete="f_name" autofocus>
                                        @error('f_name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                        <label class="focus-label">@lang('home.f_name')</label>
                                    </div>

                                    <div class="col-md-6 form-wrap form-focus">
                                    <span class="form-icon">
                                        <i class="feather-user"></i>
                                    </span>
                                        <input id="l_name" type="text"  class="form-control floating @error('l_name') is-invalid @enderror" name="l_name" value="{{ old('l_name') }}" required autocomplete="l_name" autofocus>
                                        @error('l_name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                        <label class="focus-label">@lang('home.l_name') </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-wrap form-focus">
                                        <span class="form-icon">
                                            <i class="feather-mail"></i>
                                        </span>
                                        <input type="email"  name="email" autocomplete="off" class="form-control floating @error('email') is-invalid @enderror"  value="{{ old('email') }}"/>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label class="focus-label">@lang('home.email')</label>
                                    </div>

                                    @php
                                        $nationalities = App\Models\Dashboard\Nationality\Nationality::all();
                                    @endphp

                                    <div class="col-md-6 form-wrap form-focus">
                                        <span class="form-icon">
                                            <i class="feather-phone"></i>
                                        </span>
                                        <input type="number"  name="phone" autocomplete="off" class="form-control floating @error('phone') is-invalid @enderror" value="{{ old('phone') }}"/>
                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label class="focus-label">@lang('home.phone')</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-wrap form-focus">
                                        <span class="form-icon">
                                            <i class="feather-credit-card"></i>
                                        </span>
                                        <input type="number"  name="ssn" autocomplete="off" class="form-control floating @error('ssn') is-invalid @enderror" value="{{ old('ssn') }}"/>
                                        @error('ssn')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label class="focus-label">@lang('home.ssn')</label>
                                    </div>


                                    <div class="col-md-4 form-wrap form-focus">
                                    <span class="form-icon">
                                        <i class="feather-flag"></i>
                                    </span>
                                        <select class="form-control select2 select" name="gender" required>
                                            <option value="male" selected> @lang('home.male')</option>
                                            <option value="female"> @lang('home.female')</option>
                                        </select>
                                        @error('gender')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 form-wrap form-focus">
                                    <span class="form-icon">
                                        <i class="feather-flag"></i>
                                    </span>
                                        <select class="form-control select2 select" name="nationality_id" required>
                                            @foreach($nationalities as $nationality)
                                                <option value="{{ $nationality->id }}" {{  $nationality->id == 150 ? 'selected' : '' }}>
                                                    {{ $nationality->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('nationality_id')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-wrap form-focus pass-group">
                                    <span class="form-icon">
                                        <i class="toggle-password feather-eye-off"></i>
                                    </span>

                                        <input class="form-control floating pass-input @error('password') is-invalid @enderror" type="password"  name="password" autocomplete="off" data-gtm-form-interact-field-id="0">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                        <label class="focus-label"> @lang('home.password')</label>
                                    </div>

                                    <div class="col-md-6 form-wrap form-focus pass-group">
                                <span class="form-icon">
                                    <i class="toggle-password-confirm feather-eye-off"></i>
                                </span>
                                        <input class="form-control floating pass-confirm" type="password"  name="password_confirmation" autocomplete="off" data-gtm-form-interact-field-id="0">

                                        <label class="focus-label">@lang('home.confirm_password')</label>
                                    </div>
                                </div>

                                <div class="form-wrap">
                                    <label class="custom_check mb-0"> @lang('home.when click you accept') <a href="javascript::void" class="fw-bold">@lang('home.terms_of_use')</a> و <a class="fw-bold" href="javascrip::void"> @lang('home.privacy_policy')</a>
                                        <input type="checkbox" name="remember">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary"> @lang('home.Sign up')</button>
                            </div>
                            <div class="acc-in">
                                <p>@lang('home.Already have an Account?') <a href="{{route('login')}}">@lang('home.login')</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- /Register Content -->

    </div>
    <!-- /Sign Up -->

@endsection
