@php
    $displayNone = $displayNone ?? false;
    $readonly = $readonly ?? '';
@endphp

<div class="fv-row w-{{ $width ?? '100' }} flex-md-root" @if ($displayNone) style="display: none" @endif id="{{ $id ?? $name }}_div">
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
    <input type="{{ $type ?? 'text' }}" @if(($type ?? '') === 'number') step="{{ $step ?? 'any' }}" @endif
        name="{{ $name }}" id="{{ $id ?? $name }}" value="{{ old($name, $value ?? '') }}"
        @if ($readonly) readonly @endif
        class="form-control mb-2 @error($name) is-invalid @enderror {{ $customClass ?? '' }}"
        @if(isset($inputId)) id="{{ $inputId }}" @endif
        placeholder="{{ $placeholder ?? '' }}" {{ $required ?? '' }} {{ $disabled ?? '' }}
        @isset($min) min="{{ $min??''}}"@endisset @isset($max) max="{{$max??''}}"@endisset>
    @error($errorName ?? $name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <!--end::Input-->
</div>
