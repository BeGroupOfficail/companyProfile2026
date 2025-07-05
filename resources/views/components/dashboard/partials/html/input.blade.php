@php
    $displayNone = $displayNone ?? false;
@endphp

<div class="fv-row w-{{ $width ?? '100' }} flex-md-root" @if($displayNone) style="display: none"  @endif>
    <!--begin::Label-->
    <label class="form-label  text-nowrap {{ $required ?? '' }} " for="{{ $name }}">{{ $label }}</label>
    <!--end::Label-->
    @if (isset($label2) || isset($href) || isset($icon))
        <span class="mx-2">
            @if (isset($href))
                <a href="{{ $href }}" target="_blank">
                    @if (isset($label2))
                        <span class="text-danger">{{ $label2 }}</span>
                    @endif
                    @if (isset($icon))
                        {!! $icon !!}
                    @endif
                </a>
            @else
                @if (isset($label2))
                    <span class="text-danger">{{ $label2 }}</span>
                @endif
                @if (isset($icon))
                    {!! $icon !!}
                @endif
            @endif
        </span>
    @endif

    <!--begin::Input-->
    <input type="{{ $type ?? 'text' }}" {{ isset($type) ? ($type == 'number' ? 'step="0.01" ' : '') : '' }}
        name="{{ $name }}" id="{{ $id ?? $name }}" value="{{ old($name, $value ?? '') }}"
        class="form-control mb-2 @error($name) is-invalid @enderror {{ $customClass ?? '' }}"
        placeholder="{{ $placeholder ?? '' }}" {{ $required ?? '' }} {{ $disabled ?? '' }} @isset($min) min="{{ $min ?? '' }} @endisset"
       >

    @error($errorName ?? $name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <!--end::Input-->
</div>
