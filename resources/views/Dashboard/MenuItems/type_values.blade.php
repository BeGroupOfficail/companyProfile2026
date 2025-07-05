@if(in_array($type,['main-menu','home','about-us','contact-us','tours','blogs',
                    'categories','pages','destinations','blog-categories','services',
                    ]) )

@elseif($type == 'link')
    <!--begin::Input-->
    <div class="fv-row w-100 flex-md-root">
        <!--begin::Label-->
        <label class="form-label  text-nowrap required" for="link">@lang('dash.link')</label>
        <input type="text" name="link" id="link" class="form-control mb-2 @error('link') is-invalid @enderror" placeholder="{{ __('dash.Enter the link') }}" value="{{$menuItem->link??''}}">
        @error('link')
            <div class="invalid-feedback">{{ $message }}</div>
         @enderror
    </div>
    <!--end::Input-->
@else
    <!--begin::Form Group-->
    <div class="mb-4" >
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
                        @selected(old('type_value_id', $menuItem->type_value_id ?? null) == $value->id)
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
