<x-dashboard.layout :title="__('dash.add_sub_section_item')">

    <!--begin::Form-->
    <form method="post" action="{{route('sub-section-items.store')}}" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('sub-section-items.index')}}" enctype="multipart/form-data">
        @csrf
        <!--begin::Aside column-->
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <!--begin::SubSection-->
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('dash.sub_section') }}</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-2" data-control="select2" name="sub_section_id" data-placeholder="{{ __('dash.Select an option') }}">
                        @foreach($subSections as $subSection)
                            <option value="{{ $subSection->id }}" {{ old('sub_section_id') == $subSection->id ? 'selected' : '' }}>
                                {{ $subSection->getTranslation('title', app()->getLocale()) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!--end::SubSection-->
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
                                
                                <div class="mt-5">
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
                <a href="{{route('sub-section-items.index')}}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">{{__('dash.Cancel')}}</a>
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

</x-dashboard.layout>
