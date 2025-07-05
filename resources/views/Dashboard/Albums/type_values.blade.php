@if($type == 'general')
@else
    <!--begin::Form Group-->
    <div class="mb-4">
        <!--begin::Label-->
        <label for="type_value_id" class="form-label required">
            @lang("dash.$type")
        </label>
        <!--end::Label-->

        <!--begin::Select2-->
        <select id="type_value_id" name="type_value_id"
                class="form-select mb-2 @error('type_value_id') is-invalid @enderror"
                data-control="select2"
                data-placeholder="@lang('dash.Select an option')"
                data-hide-search="false"
                aria-label="@lang('dash.Select') @lang("dash.$type")"
                required>

            <option value="" disabled selected>@lang('dash.Select an option')</option>

            @foreach($values as $value)
                <option value="{{ $value->id }}"
                        @selected(old('type_value_id', $album->type_value_id ?? null) == $value->id)
                        data-lang="{{ $lang }}">
                    {{ $value->getTranslation('name', $lang) }}
                </option>
            @endforeach
        </select>
        <!--end::Select2-->

        <!--begin::Error-->
        @error('type_value_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        <!--end::Error-->
    </div>
    <!--end::Form Group-->
@endif
