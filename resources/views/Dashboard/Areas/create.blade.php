<x-dashboard.layout :title="__('dash.add_area')">

    <form method="post" action="{{ route('settings.areas.store') }}" class="form d-flex flex-column flex-lg-row"
        data-kt-redirect="{{ route('settings.areas.index') }}" enctype="multipart/form-data">
        @csrf
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab1" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">

                        <div class="card card-flush py-4">
                            <div class="card-body pt-0">
                                <div class="d-flex flex-wrap gap-5">
                                    @foreach (config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.input name="name_{{ $lang }}"
                                            label="{{ __('dash.name') }} ({{ __($languageName) }})" :value="old('name_' . $lang, '')"
                                            placeholder="{{ __('dash.Enter the name in') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>
                                <x-dashboard.partials.html.select :options="$countries" :name="'country_id'" :id="'country-select'"
                                    :title="__('dash.country')" />
                                <x-dashboard.partials.html.select :options="[]" :name="'region_id'" :title="__('dash.region')"
                                    :id="'region-select'" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('settings.areas.index') }}" id="kt_ecommerce_add_product_cancel"
                    class="btn btn-light me-5">{{ __('dash.Cancel') }}</a>
                <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                    <span class="indicator-label">{{ __('dash.Save Changes') }}</span>
                    <span class="indicator-progress">{{ __('dash.Please wait...') }} <span
                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </div>
    </form>

</x-dashboard.layout>
<script>
    let selectText = {!! json_encode(__('dash.select_region')) !!};
    let userLang = "{{ app()->getLocale() }}"; // Get current language from Laravel
</script>

<script>
    $(document).ready(function () {
        console.log('dasd');
        $('#country-select').change(function () {
            let countryId = $(this).val();
            console.log(countryId);
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
