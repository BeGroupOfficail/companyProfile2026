@php
    $selectedValue = $selectedValue ?? old($name);
    $isMultiple = $isMultiple ?? false;
    $selectedArray = $selectedArray ?? [];
    $textTranslated = $textTranslated ?? false;
@endphp
<!--begin::Input group-->
<div class="fv-row w-{{ $width ?? '100' }} {{ $customClass ?? '' }} @if(!isset($withOutFlex)) flex-md-root @endif" id="{{ $divId ?? '' }}">
    <!--begin::Label-->
    <label class="{{$required ??''}}  form-label">{{$title}} </label>
    <!--end::Label-->
    <!--begin::Select2-->

    <select id="{{$id ?? $name}}" {{$disabled ??''}}  name="{{ $name }}" aria-label="Select {{ $name }}"
    data-control="select2" data-placeholder="{{__('dash.Select an option')}}"
    class="form-select mb-2 {{ $addClass??''}}" data-allow-clear="true" {{$required ??''}} {{$isMultiple ? 'multiple' : ''}}>
    <option></option>
    @foreach($options??[] as $value => $text)
            <option value="{{ $value }}" @if($selectedArray)
                @selected(in_array($value , old($name, $selectedArray)))
                @else
                @selected(old($name, $selectedValue) == $value) @endif
                >{{ $textTranslated ? trans("dash.$text") : $text }}</option>
        @endforeach
    </select>
    <!--end::Select2-->

    @error($errorName ?? $name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<!--end::Input group-->
