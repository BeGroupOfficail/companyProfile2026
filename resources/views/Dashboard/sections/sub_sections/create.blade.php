<x-dashboard.layout :title="__('dash.add_sub_section')">

    <!--begin::Form-->
    <form method="post" action="{{route('sub-sections.store')}}" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('sub-sections.index')}}" enctype="multipart/form-data">
        @csrf
        <!--begin::Aside column-->
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <!--begin::Section-->
            {{-- <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('dash.section') }}</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" data-control="select2" name="section_id" data-placeholder="{{ __('dash.Select an option') }}">
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                {{ $section->getTranslation('title', app()->getLocale()) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div> --}}
            <!--end::Section-->

            <!--begin::Layout-->
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('dash.layout') }}</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="{{ __('dash.Select an option') }}" name="layout">
                        <option value="title_desc" selected="selected">{{ __('dash.title_desc') }}</option>
                        <option value="title_only">{{ __('dash.title_only') }}</option>
                    </select>
                </div>
            </div>
            <!--end::Layout-->
        </div>
        <!--end::Aside column-->

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
                                    <x-dashboard.partials.html.input
                                        name="sort_order"
                                        type="number"
                                        label="{{ __('dash.sort_order') }}"
                                        :value="old('sort_order', 0)"
                                        placeholder="0" />

                                    <x-dashboard.partials.html.input
                                        name="key"
                                        type="text"
                                        label="{{ __('dash.key') }}"
                                        :value="old('key', '')"
                                        placeholder="{{ __('dash.key') }}"
                                        required="required" />
                                </div>

                                <div class="d-flex flex-wrap gap-5 mt-5">
                                    @foreach(config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.input
                                            name="title_{{ $lang }}"
                                            label="{{ __('dash.title') }} ({{ __($languageName) }})"
                                            :value="old('title_' . $lang, '')"
                                            placeholder="{{ __('dash.title') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>
                                
                                <div class="mt-5" id="description-section">
                                    @foreach(config('languages') as $lang => $languageName)
                                        <label class="form-label">{{ __('dash.description') }} ({{ __($languageName) }})</label>
                                        <textarea class="form-control mb-5" name="description_{{ $lang }}">{{ old('description_' . $lang, '') }}</textarea>
                                    @endforeach
                                </div>

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
                <a href="{{route('sub-sections.index')}}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">{{__('dash.Cancel')}}</a>
                <!--end::Button-->

                <!--begin::Button-->
                <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                    <span class="indicator-label">{{__('dash.Save Changes')}}</span>
                    <span class="indicator-progress">{{__('dash.Please wait...')}} <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Button-->
            </div>
        </div>
        <!--end::Main column-->
    </form>
    <!--end::Form-->

    @push('scripts')
        <script>
            $(document).ready(function() {
                var layoutSelect = $('select[name="layout"]');
                var descriptionSection = $('#description-section');

                function toggleDescription() {
                    if (layoutSelect.val() === 'title_only') {
                        descriptionSection.hide();
                    } else {
                        descriptionSection.show();
                    }
                }

                layoutSelect.on('change', toggleDescription);
                toggleDescription(); // Initial state on page load
            });
        </script>
    @endpush

</x-dashboard.layout>
