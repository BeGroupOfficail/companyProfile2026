<div class="fv-row w-{{ $width ?? '100' }} flex-md-root" data-kt-password-meter="true">
    <!--begin::Wrapper-->
    <div class="mb-1">
        <!--begin::Input wrapper-->
        <div class="position-relative mb-3">
            <label class="form-label">{{__('dash.password')}}</label>
            <input class="form-control bg-transparent @error('password') is-invalid @enderror" type="password" placeholder="{{__('dash.password')}}" name="password" autocomplete="off" data-gtm-form-interact-field-id="0">

            <span class="btn btn-sm btn-icon position-absolute translate-middle top-70 end-0 me-n2" data-kt-password-meter-control="visibility">
              <i class="ki-outline ki-eye-slash fs-2 "></i>
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

<div class="fv-row w-{{ $width ?? '100' }} flex-md-root" data-kt-password-meter="true">
    <!--begin::Wrapper-->
    <div class="mb-1">
        <!--begin::Input wrapper-->
        <div class="position-relative mb-3">
            <label class="form-label">{{__('dash.confirm password')}}</label>
            <input class="form-control bg-transparent" type="password" placeholder="{{__('dash.confirm password')}}" name="password_confirmation" autocomplete="off" data-gtm-form-interact-field-id="0">

            <span class="btn btn-sm btn-icon position-absolute translate-middle top-70 end-0 me-n2" data-kt-password-meter-control="visibility">
                <i class="ki-outline ki-eye-slash fs-2 "></i>
                <i class="ki-outline ki-eye fs-2 d-none"></i>
            </span>
        </div>
        <!--end::Input wrapper-->

    </div>
    <!--end::Wrapper-->

    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
</div>
