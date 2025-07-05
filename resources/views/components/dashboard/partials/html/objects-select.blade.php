@php
    $selectedValue = $selectedValue ?? old($name);
    $dataAttribute = $dataAttribute ?? [];
    $isMultiple = $isMultiple ?? false;
    $isTranslatable = $isTranslatable ?? false;
    $isUserModel = $isUserModel ?? false;
    $translatableValue = $translatableValue ?? false;
    $selectedArray = $selectedArray ?? [];
@endphp
<!--begin::Input group-->
<div class="fv-row w-100 flex-md-root">
    <!--begin::Label-->
    <label class="{{ $required ?? '' }}  form-label">{{ $title }}</label>
    <!--end::Label-->
    <!--begin::Select2-->
    <select id="{{ $id ?? $name }}" {{ $disabled ?? '' }} name="{{ $name }}"
        aria-label="Select {{ $name }}" data-control="select2" data-placeholder="{{ __('dash.Select an option') }}"
        class="form-select mb-2" data-hide-search="false" data-allow-clear="true" {{ $required ?? '' }} {{ $isMultiple ? 'multiple' : '' }}>
        <option></option>

        @foreach ($options as $option)
            <option value="{{ $option?->id ?? $option }}" {{ $dataAttribute ? "data-$dataAttribute={$option->$dataAttribute}" : '' }}
                @if($selectedArray) 
                {{-- @dd(old($name, $selectedArray)) --}}
                    @selected(in_array($option->id , old($name, $selectedArray))) 
                @else
                    @selected(old($name, $selectedValue) == ($option?->id ?? $option)) 
                @endif >
                {{ $isUserModel ? $option->name : ($isTranslatable ? $option->getTranslation("$translatableValue", app()->getLocale()) : __("dash.$option")) }}
            </option>
        @endforeach
    </select>
    <!--end::Select2-->
    @error($errorName ?? $name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<!--end::Input group-->
