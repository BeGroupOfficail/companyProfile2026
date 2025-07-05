<x-dashboard.layout :title="__('dash.edit_area')">

    <!--begin::Form-->
    <form method="POST" action="{{route('settings.areas.update',$area->id)}}" class="form d-flex flex-column flex-lg-row">
        @csrf
        @method('PATCH')

        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
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
                                            :value="old('name_' . $lang, $area->getTranslation('name', $lang) ?? '')"
                                            placeholder="{{ __('dash.Enter the name in') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>
                                <x-dashboard.partials.html.select :options="$countries" :selectedValue="$area->region->country_id" :name="'country_id'"
                                    :title="__('dash.country')" :id="'country-select'"/>
                                <x-dashboard.partials.html.select :options="$regions" :selectedValue="$area->region->id" :name="'region_id'"
                                     :title="__('dash.region')" :id="'region-select'"  />

                            </div>
                            <!--end::Card header-->

                        </div>
                        <!--end::General options-->

                    </div>
                </div>
                <!--end::Tab pane-->
            </div>
            <!--end::Tab content-->

            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <a href="{{route('settings.areas.index')}}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">{{__('dash.Cancel')}}</a>
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

</x-dashboard.layout>
<script>
    let selectText = {!! json_encode(__('dash.select_region')) !!};
    let userLang = "{{ app()->getLocale() }}"; // Get current language from Laravel
</script>

<script>
    $(document).ready(function () {
        $('#country-select').change(function () {
            let countryId = $(this).val();
            if (!countryId) return;

            $.ajax({
                url: "{{ route('settings.getCountryRegions') }}",
                type: "GET",
                data: { country_id: countryId },
                success: function (response) {
                    let regionSelect = $('#region-select');
                    regionSelect.empty(); // Clear previous options

                    // Append default option
                    regionSelect.append(`<option value="">${selectText}</option>`);

                    // Append new options with the correct language
                    $.each(response, function (key, region) {
                        let regionName = region.name[userLang] || region.name['en']; // Fallback to English if language not found
                        regionSelect.append(`<option value="${region.id}">${regionName}</option>`);
                    });
                },
                error: function () {
                    alert("Failed to fetch regions.");
                }
            });
        });
    });
</script>
