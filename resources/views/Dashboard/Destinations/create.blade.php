<x-dashboard.layout :title="__('dash.add_destination')">

    <!--begin::Form-->
    <form method="post" action="{{route('destinations.store')}}" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('destinations.index')}}" enctype="multipart/form-data">
        @csrf
        <!--begin::Aside column-->
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">

            <!--begin::image-->
             <x-dashboard.partials.html.image_input
                :title="'Upload Image'"
                :name="'image'"
                :description="'Only *.png, *.jpg, and *.jpeg image files are accepted.'"
                :changeImageText="'Change Image'"
                :cancelImageText="'Cancel Image'"
                :removeImageText="'Remove Image'"
                :acceptedText="'image files are accepted'"
            />
            <!--end::image -->

            <!--begin::Status-->

            <x-dashboard.partials.html.status_select
                :model="'destination'"
            />

            <!--end::Status-->
        </div>
        <!--end::Aside column-->

        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#tab1">{{ __('dash.main info') }}</a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#tab2">{{ __('dash.seo info') }}</a>
                </li>
                <!--end:::Tab item-->

            </ul>
            <!--end:::Tabs-->

            <!--begin::Tab content-->
            <div class="tab-content">
                <!--begin::Tab pane-->
                <div class="tab-pane fade show active" id="tab1" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">

                        <!--begin::General options-->
                        <div class="card card-flush py-4">

                            <!--begin::Card body-->
                            <div class="card-body pt-0">

                                <div class="d-flex flex-wrap gap-5">

                                    @foreach(config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.input
                                            name="name_{{ $lang }}"
                                            label="{{ __('dash.name') }} ({{ __($languageName) }})"
                                            :value="old('name_' . $lang, '')"
                                            placeholder="{{ __('dash.Enter the name in') }} {{ __($languageName) }}" />
                                    @endforeach

                                    <x-dashboard.partials.html.objects-select
                                        name="country_id"
                                        title="{{ __('dash.countries') }}"
                                        :options="$countries"
                                        :isTranslatable="true"
                                        :translatableValue="'name'"
                                        :id="'country-select'"/>

                                    <x-dashboard.partials.html.select :options="[]" :name="'region_id'"
                                                                      :title="__('dash.region')" width="25" :id="'region-select'" />
                                </div>


                                @foreach(config('languages') as $lang => $languageName)
                                    <x-dashboard.partials.html.textarea_with_editor
                                        name="long_desc_{{ $lang }}"
                                        label="{{ __('dash.long_desc') }} ({{ __($languageName) }})"
                                        :value="old('name_' . $lang, '')"
                                        placeholder="{{ __('dash.Enter the long dec in') }} {{ __($languageName) }}" />
                                @endforeach

                                <div class="d-flex flex-wrap gap-5">
                                    <div class="row fv-row mb-7">
                                        <div class="col-md-6 text-md-end">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>@lang('dash.featured')</span>
                                                <span class="ms-1" data-bs-toggle="tooltip" >
                                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                </span>
                                            </label>
                                            <!--end::Label-->
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex mt-3">
                                                <!--begin::Radio-->
                                                <div class="form-check form-check-custom form-check-solid me-5">
                                                    <input class="form-check-input" type="radio" value="1" name="featured" @checked(old('featured') == 1)>
                                                    <label class="form-check-label" for="header_yes">@lang('dash.yes')</label>
                                                </div>

                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" value="0" name="featured"  @checked(old('featured') == 0)>
                                                    <label class="form-check-label" for="header_no">@lang('dash.no')</label>
                                                </div>
                                                <!--end::Radio-->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <div class="row fv-row mb-7">
                                        <div class="col-md-6 text-md-end">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>@lang('dash.home_publish')</span>
                                                <span class="ms-1" data-bs-toggle="tooltip" >
                                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                </span>
                                            </label>
                                            <!--end::Label-->
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex mt-3">
                                                <!--begin::Radio-->
                                                <div class="form-check form-check-custom form-check-solid me-5">
                                                    <input class="form-check-input" type="radio" value="1" name="home" @checked(old('home') == 1)>
                                                    <label class="form-check-label" for="home_yes">@lang('dash.yes')</label>
                                                </div>

                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" value="0" name="home" @checked(old('home') == 0)>
                                                    <label class="form-check-label" for="home_no">@lang('dash.no')</label>
                                                </div>
                                                <!--end::Radio-->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <div class="row fv-row mb-7">
                                        <div class="col-md-6 text-md-end">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>@lang('dash.menu_publish')</span>
                                                <span class="ms-1" data-bs-toggle="tooltip" >
                                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                </span>
                                            </label>
                                            <!--end::Label-->
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex mt-3">
                                                <!--begin::Radio-->
                                                <div class="form-check form-check-custom form-check-solid me-5">
                                                    <input class="form-check-input" type="radio" value="1" name="menu" @checked(old('menu') == 1)>
                                                    <label class="form-check-label" for="header_yes">@lang('dash.yes')</label>
                                                </div>

                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" value="0" name="menu"  @checked(old('menu') == 0)>
                                                    <label class="form-check-label" for="header_no">@lang('dash.no')</label>
                                                </div>
                                                <!--end::Radio-->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--end::Card header-->

                        </div>
                        <!--end::General options-->

                    </div>
                </div>
                <!--end::Tab pane-->

                <!--begin::Tab pane-->
                <div class="tab-pane fade" id="tab2" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">

                        <!--begin::Inventory-->
                        <div class="card card-flush py-4">

                            <!--begin::Card body-->
                            <div class="card-body pt-0">

                                <div class="d-flex flex-wrap gap-5">
                                    @foreach(config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.input
                                            name="slug_{{ $lang }}"
                                            label="{{ __('dash.slug') }} ({{ __($languageName) }})"
                                            :value="old('slug_' . $lang, '')"
                                            placeholder="{{ __('dash.Enter the slug in') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>

                                <hr class="low-opacity">

                                <div class="d-flex flex-wrap gap-5">
                                    @foreach(config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.input
                                            name="meta_title_{{ $lang }}"
                                            label="{{ __('dash.meta_title') }} ({{ __($languageName) }})"
                                            :value="old('slug_' . $lang, '')"
                                            placeholder="{{ __('dash.Enter the meta title in') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    @foreach(config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.textarea
                                            name="meta_desc_{{ $lang }}"
                                            label="{{ __('dash.meta_desc') }} ({{ __($languageName) }})"
                                            :value="old('meta_desc_' . $lang, '')"
                                            placeholder="{{ __('dash.Enter the meta desc in') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>

                                <x-dashboard.partials.html.checkbox
                                    :name="'index'"
                                    :label="__('dash.Allow index')"
                                    :option=" 'Yes'"
                                    :description="__('dash.Allow index to make google robot crawling this url')"
                                />

                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::Inventory-->

                    </div>
                </div>
                <!--end::Tab pane-->

            </div>
            <!--end::Tab content-->

            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <a href="{{route('destinations.index')}}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">{{__('dash.Cancel')}}</a>
                <!--end::Button-->

                <!--begin::Button-->
                <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                    <span class="indicator-label">{{__('dash.Save Changes')}}</span>
                    <span class="indicator-progress">{{__('dash.Please wait...')}} <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                 </span>
                </button>
                <!--end::Button-->
            </div>
        </div>
        <!--end::Main column-->
    </form>
    <!--end::Form-->

    @push('scripts')
        {{-- Country - Regions - Areas Handling --}}
        <script>
            $(document).ready(function() {
                let regionSelectText = {!! json_encode(__('dash.select_region')) !!};
                let areaSelectText = {!! json_encode(__('dash.select_area')) !!};
                let userLang = "{{ app()->getLocale() }}"; // Get current language from Laravel

                $('#country-select').change(function() {
                    let countryId = $(this).val();
                    if (!countryId) return;

                    $.ajax({
                        url: "{{ route('settings.getCountryRegions') }}",
                        type: "GET",
                        data: {
                            country_id: countryId
                        },
                        success: function(response) {
                            let regionSelect = $('#region-select');
                            regionSelect.empty(); // Clear previous options

                            // Append default option
                            regionSelect.append(`<option value="">${regionSelectText}</option>`);

                            // Append new options with the correct language
                            $.each(response, function(key, region) {
                                let regionName = region.name[userLang] || region.name[
                                    'en']; // Fallback to English if language not found
                                regionSelect.append(
                                    `<option value="${region.id}">${regionName}</option>`
                                );
                            });
                        },
                        error: function() {
                            alert("{{ trans('dash.Failed to fetch regions.') }}");
                        }
                    });
                });

                $('#region-select').change(function() {
                    let regionId = $(this).val();
                    if (!regionId) return;

                    $.ajax({
                        url: "{{ route('settings.getRegionAreas') }}",
                        type: "GET",
                        data: {
                            region_id: regionId
                        },
                        success: function(response) {
                            let areaSelect = $('#area-select');
                            areaSelect.empty(); // Clear previous options

                            // Append default option
                            areaSelect.append(`<option value="">${areaSelectText}</option>`);

                            // Append new options with the correct language
                            $.each(response, function(key, area) {
                                let areaName = area.name[userLang] || area.name[
                                    'en']; // Fallback to English if language not found
                                areaSelect.append(
                                    `<option value="${area.id}">${areaName}</option>`);
                            });
                        },
                        error: function() {
                            alert("Failed to fetch areas.");
                        }
                    });
                });
            });
        </script>
    @endpush

</x-dashboard.layout>
