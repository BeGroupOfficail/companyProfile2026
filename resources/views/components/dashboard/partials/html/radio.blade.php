<div class="fv-row w-100 flex-md-root">
    <!--begin::Label-->
    <label class="form-label" for="{{ $name }}">{{ $label }}</label>
    <!--end::Label-->

    <!--begin::Radio Options-->
    <div class="row">
        @foreach($options as $key => $option)
            <div class="col">
                <!--begin::Option-->
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary @if(old($name) == $key || (isset($value) && $value == $key)) active @endif d-flex text-start p-6" data-kt-button="true">
                    <!--begin::Radio-->
                    <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="{{ $name }}"
                        value="{{ $key }}"
                        @if(old($name) == $key || (isset($value) && $value == $key)) checked @endif
                    />
                </span>
                    <!--end::Radio-->

                    <!--begin::Info-->
                    <span class="ms-5">
                    <span class="fs-4 fw-bold text-gray-800 d-block">{{ $option }}</span>
                </span>
                    <!--end::Info-->
                </label>
                <!--end::Option-->
            </div>
        @endforeach
    </div>
    <!--end::Radio Options-->

    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{--To use it in any blade file --}}
{{--<x-dashboard.partials.html.radio--}}
{{--    :name="'discount_option'"--}}
{{--    :label="'Select Discount Option'"--}}
{{--    :options="['1' => 'Option 1', '2' => 'Option 2']"--}}
{{--    :value="old('discount_option')"--}}
{{--/>--}}
