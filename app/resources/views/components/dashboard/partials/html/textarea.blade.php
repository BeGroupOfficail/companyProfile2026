<div class="fv-row w-100 flex-md-root">
    <!--begin::Label-->
    <label class="form-label {{$required ??''}}" for="{{ $name }}">{{ $label }}</label>
    <!--end::Label-->

    <!--begin::Textarea-->
    <textarea
    {{$required ??''}}
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        class="form-control mb-2 @error($name) is-invalid @enderror"
        placeholder="{{ $placeholder ?? '' }}"
        rows="{{ $rows ?? 4 }}">{{ old($name, $value ?? '') }}</textarea>
    <!--end::Textarea-->

    @error($errorName ?? $name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
