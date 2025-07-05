<div class="fv-row">
    <!--begin::Label-->
    <label class="form-label" for="{{ $name }}">{{ $label }}</label>
    <!--end::Label-->

    <!--begin::Input-->
    <div class="form-check form-check-custom form-check-solid mb-2">
        <input
            class="form-check-input"
            type="checkbox"
            name="{{ $name }}"
            value="1"
            id="{{ $name }}"
            @checked(old($name, $model->{$name} ?? 0) == 1)
        />
        <label class="form-check-label" for="{{ $name }}">
            {{ $option }}
        </label>
    </div>



    <!--end::Input-->

    <!--begin::Description-->
    <div class="text-muted fs-7">{{ $description }}</div>
    <!--end::Description-->
</div>
