<x-authentication.layout title="{{__('Register')}}">


<form class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate" id="kt_sign_up_form" data-kt-redirect-url="{{route('dashboard.home')}}" action="{{route('register')}}" method="post" data-gtm-form-interact-id="0">
       @csrf

        <!--begin::Heading-->
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-gray-900 fw-bolder mb-3">
                {{__('Sign Up')}}
            </h1>
            <!--end::Title-->
        </div>
        <!--begin::Heading-->

    {{--    <x-authentication.partials.social_login_options/>--}}

    <!--begin::Separator-->
    <div class="separator separator-content my-14">
        <span class="w-125px text-gray-500 fw-semibold fs-7">{{__('dash.with email')}}</span>
    </div>
    <!--end::Separator-->

        <input type="hidden" name="register_type" value="admin">

        <!--begin::Input group--->
        <div class="d-flex flex-wrap gap-5  mb-8">
            <div class="fv-row w-100 flex-md-root">
                <input id="f_name" type="text"  placeholder="{{__('dash.f_name')}}" class="form-control @error('f_name') is-invalid @enderror" name="f_name" value="{{ old('f_name') }}" required autocomplete="f_name" autofocus>
                @error('f_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="fv-row w-100 flex-md-root">
                <input id="l_name" type="text"  placeholder="{{__('dash.l_name')}}" class="form-control @error('l_name') is-invalid @enderror" name="l_name" value="{{ old('l_name') }}" required autocomplete="l_name" autofocus>
                @error('l_name')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="fv-row mb-8 fv-plugins-icon-container">
            <input id="email" type="email" placeholder="{{__('dash.email')}}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="fv-row mb-8 fv-plugins-icon-container" data-kt-password-meter="true">
            <!--begin::Wrapper-->
            <div class="mb-1">
                <!--begin::Input wrapper-->
                <div class="position-relative mb-3">
                    <input class="form-control bg-transparent @error('password') is-invalid @enderror" type="password" placeholder="{{__('dash.password')}}" name="password" autocomplete="off" data-gtm-form-interact-field-id="0">

                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                    <i class="ki-outline ki-eye-slash fs-2"></i>
                        <i class="ki-outline ki-eye fs-2 d-none"></i>
                    </span>
                </div>
                <!--end::Input wrapper-->

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror


            </div>
            <!--end::Wrapper-->
        </div>

        <div class="fv-row mb-8 fv-plugins-icon-container" data-kt-password-meter="true">
            <!--begin::Wrapper-->
            <div class="mb-1">
                <!--begin::Input wrapper-->
                <div class="position-relative mb-3">
                    <input class="form-control bg-transparent" type="password" placeholder="{{__('dash.confirm password')}}" name="password_confirmation" autocomplete="off" data-gtm-form-interact-field-id="0">

                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                        <i class="ki-outline ki-eye-slash fs-2"></i>
                        <i class="ki-outline ki-eye fs-2 d-none"></i>
                    </span>
                </div>
                <!--end::Input wrapper-->

            </div>
            <!--end::Wrapper-->

            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
        </div>

        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                <!--begin::Indicator label-->
                <span class="indicator-label">{{__('dash.Sign up')}} </span>
                <!--end::Indicator label-->

                <!--begin::Indicator progress-->
                <span class="indicator-progress">{{__('dash.Please wait...')}} <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
                <!--end::Indicator progress-->
            </button>
        </div>


        <!--begin::Sign up-->
        <div class="text-gray-500 text-center fw-semibold fs-6">

            {{__('dash.Already have an Account?')}}

            <a href="{{route('login')}}" class="link-primary fw-semibold">
                {{__('dash.Login')}}
            </a>
        </div>
        <!--end::Sign up-->
    </form>

</x-authentication.layouts>
