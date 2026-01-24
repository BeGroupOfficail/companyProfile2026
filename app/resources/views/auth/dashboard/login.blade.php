<x-authentication.layout :title="__('dash.Login')">
    <!--begin::Form-->
    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="{{route('dashboard.home')}}" action="{{route('dashboard.login')}}" method="POST">
        @csrf
        <!--begin::Heading-->
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-gray-900 fw-bolder mb-3">
                {{__('dash.Sign In')}}
            </h1>
            <!--end::Title-->
        </div>
        <!--begin::Heading-->

        <!--begin::Separator-->
        <div class="separator separator-content my-14">
            <span class="">{{__('dash.with email')}}</span>
        </div>
        <!--end::Separator-->

        <!--begin::Input group--->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="email" placeholder="{{ __('dash.email') }}" name="email" autocomplete="off" class="form-control bg-transparent @error('email') is-invalid @enderror" />
            @error('email')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <!--end::Email-->
        </div>

        <!--end::Input group--->
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
        <!--end::Input group--->

        <!--begin::Wrapper-->
        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
            <div></div>
        </div>
        <!--end::Wrapper-->

        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">

                <!--begin::Indicator label-->
                <span class="indicator-label">{{__('dash.Sign In')}}</span>
                <!--end::Indicator label-->

                <!--begin::Indicator progress-->
                <span class="indicator-progress">
                    {{__('dash.Please wait...')}}
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
                <!--end::Indicator progress-->
            </button>
        </div>
        <!--end::Submit button-->
    </form>
    <!--end::Form-->
</x-authentication.layout>
