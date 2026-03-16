<div class="fv-row w-{{ $width?? 100}} flex-md-root">
    <!--begin::Label-->
    <label class="form-label" for="{{ $name }}">{{ $label }}</label>
    <!--end::Label-->

    <!--begin::Textarea-->
    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        class="form-control mb-2 area1 @error($name) is-invalid @enderror"
        placeholder="{{ $placeholder ?? '' }}"
        rows="{{ $rows ?? 4 }}">{{ old($name, $value ?? '') }}</textarea>
    <!--end::Textarea-->

    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
