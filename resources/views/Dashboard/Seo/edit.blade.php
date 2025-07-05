<x-dashboard.layout :title="__('dash.seo_assistant')">

    <!--begin::Form-->
    <form method="POST" action="{{route('seo.update',$seo->page_type)}}" class="form d-flex flex-column flex-lg-row" data-kt-redirect="" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
                @foreach($pageTypes as $pageType)
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 @if($pageType == $seo->page_type) active @endif" href="{{route('seo.edit',$pageType)}}">@lang("dash.$pageType")</a>
                    </li>
                    <!--end:::Tab item-->
                @endforeach
            </ul>
            <!--end:::Tabs-->
            <!--begin::Tab content-->
            <div class="tab-content">
                <!--begin::Tab pane-->
                <div class="tab-pane @if($seo->id)  fade show active @endif">
                    <div class="d-flex flex-column gap-7 gap-lg-10">

                        <!--begin::Inventory-->
                        <div class="card card-flush py-4">

                            <!--begin::Card body-->
                            <div class="card-body pt-0">

{{--                                <div class="d-flex flex-wrap gap-5">--}}
{{--                                    <x-dashboard.partials.html.select--}}
{{--                                        :options="$schmeaTypes"--}}
{{--                                        :selectedArray="$seo->schema_types"--}}
{{--                                        :name="'schema_types[]'"--}}
{{--                                        :title="__('dash.schema_types')"--}}
{{--                                        :id="'job-title-select'"--}}
{{--                                        :isMultiple="true"/>--}}
{{--                                </div>--}}


{{--                                <div class="m-3">--}}
{{--                                    <hr class="low-opacity">--}}
{{--                                </div>--}}

                                <div class="d-flex flex-wrap gap-5">
                                    @foreach(config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.input
                                            name="meta_title_{{ $lang }}"
                                            label="{{ __('dash.meta_title') }} ({{ __($languageName) }})"
                                            :value="old('meta_title_' . $lang, $seo->getTranslation('meta_title', $lang) ?? '')"
                                            placeholder="{{ __('dash.Enter the meta title in') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    @foreach(config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.textarea
                                            name="meta_desc_{{ $lang }}"
                                            label="{{ __('dash.meta_desc') }} ({{ __($languageName) }})"
                                            :value="old('meta_desc_' . $lang, $seo->getTranslation('meta_desc', $lang) ?? '')"
                                            placeholder="{{ __('dash.Enter the meta desc in') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>

                                <x-dashboard.partials.html.checkbox
                                    :name="'index'"
                                    :label="__('dash.Allow index')"
                                    :option="'Yes'"
                                    :description="__('dash.Allow index to make google robot crawling this url')"
                                    :model="$seo" />



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
                <a href="{{route('dashboard.home')}}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">{{__('dash.Cancel')}}</a>
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
