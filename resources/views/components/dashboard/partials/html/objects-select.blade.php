@php
    $selectedValue = $selectedValue ?? old($name);
    $dataAttribute = $dataAttribute ?? [];
    $isMultiple = $isMultiple ?? false;
    $isTranslatable = $isTranslatable ?? false;
    $isUserModel = $isUserModel ?? false;
    $showUserRole = $showUserRole ?? false;
    $translatableValue = $translatableValue ?? false;
    $valueAttribute = $valueAttribute ?? false;
    $selectedArray = $selectedArray ?? old($name);
    $hint = $hint ?? false;
@endphp
<!--begin::Input group-->
<div class="fv-row w-100 flex-md-root {{ $customClass ?? '' }}" id="{{ $divId ?? '' }}">
    <!--begin::Label-->
    <label class="{{ $required ?? '' }}  form-label">{{ $title }} @if($hint) ( <span class="text-muted">{{ $hint }}</span> ) @endif @isset($required) <span class="text-danger fs-6">*</span> @endisset</label>
    <!--end::Label-->
    <!--begin::Select2-->
    <select id="{{ $id ?? $name }}" {{ $disabled ?? '' }} name="{{ $name }}"
        aria-label="Select {{ $name }}" data-control="select2" data-placeholder="{{ __('dash.Select an option') }}"
        class="form-select mb-2 {{ $addClass ?? '' }}" data-hide-search="false" data-allow-clear="true" {{ $required ?? '' }} {{ $isMultiple ? 'multiple' : '' }}>
        <option></option>

       @foreach ($options as $option)
            @php
                $optionId = is_object($option) ? ($valueAttribute ? $option->$valueAttribute : $option->id) : $option;
                $optionLabel = $isUserModel
                    ? $option->name . ($showUserRole ? ' - ' . trans('dash.'.$option->job_role) : '')
                    : ($isTranslatable
                        ? (is_object($option) ? $option->getTranslation($translatableValue, app()->getLocale()) : __("dash.$option"))
                        : (is_object($option) ? $option->$translatableValue ?? $optionId : __("dash.$option")));
                $isSelected = false;
        
                if ($selectedArray) {
                    $isSelected = in_array($optionId, (array) old($name, $selectedArray));
                } else {
                    $isSelected = old($name, $selectedValue) == $optionId;
                }
            @endphp
        
            <option value="{{ $optionId }}"
                @if($dataAttribute && is_object($option))
                    data-{{ $dataAttribute }}="{{ $option->$dataAttribute }}"
                @endif
                @selected($isSelected)>
                {{ $optionLabel }}
            </option>
        @endforeach

    </select>
    <!--end::Select2-->
    @error($errorName ?? $name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<!--end::Input group-->
