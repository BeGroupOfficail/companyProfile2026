<x-dashboard.layout :title="__('dash.edit_about')">

    <!--begin::Form-->
    <form method="POST" action="{{route('about.update')}}" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('about.edit')}}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
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
                :model="$about"
                :imageModelName="'about'"
            />
            <!--end::image -->

            <!--begin::image-->
            <x-dashboard.partials.html.image_input
                :title="'Upload Banner'"
                :name="'banner'"
                :description="'Only *.png, *.jpg, and *.jpeg image files are accepted.'"
                :changeImageText="'Change Banner'"
                :cancelImageText="'Cancel Banner'"
                :removeImageText="'Remove Banner'"
                :acceptedText="'Banner files are accepted'"
                :model="$about"
                :imageModelName="'about'"
            />
            <!--end::image -->
        </div>
        <!--end::Aside column-->

        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#tab1">{{ __('dash.edit_about') }}</a>
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
                                            name="title_{{ $lang }}"
                                            label="{{ __('dash.title') }} ({{ __($languageName) }})"
                                            :value="old('title_' . $lang, $about->getTranslation('title', $lang) ?? '')"
                                            placeholder="{{ __('dash.Enter the title in') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>

                                @foreach(config('languages') as $lang => $languageName)
                                    <x-dashboard.partials.html.textarea_with_editor
                                        name="description_{{ $lang }}"
                                        label="{{ __('dash.description') }} ({{ __($languageName) }})"
                                        :value="old('description_' . $lang, $about->getTranslation('description', $lang) ?? '')"
                                        placeholder="{{ __('dash.Enter the description in') }} {{ __($languageName) }}" />
                                @endforeach

                                @foreach(config('languages') as $lang => $languageName)
                                    <x-dashboard.partials.html.textarea_with_editor
                                        name="why_choose_us_{{ $lang }}"
                                        label="{{ __('dash.why_choose_us') }} ({{ __($languageName) }})"
                                        :value="old('why_choose_us_' . $lang, $about->getTranslation('why_choose_us', $lang) ?? '')"
                                        placeholder="{{ __('dash.Enter the why_choose_us in') }} {{ __($languageName) }}" />
                                @endforeach

                            </div>
                            <!--end::Card header-->

                        </div>
                        <!--end::General options-->

                    </div>
                </div>
                <!--end::Tab pane-->

                <!--begin::Tab pane-->
                <div class="tab-pane" id="tab2" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">

                        <!--begin::Inventory-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>{{__('dash.seo info')}}</h2>
                                </div>
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">

                                <div class="d-flex flex-wrap gap-5">
                                    @foreach(config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.input
                                            name="slug_{{ $lang }}"
                                            label="{{ __('dash.slug') }} ({{ __($languageName) }})"
                                            :value="old('slug_' . $lang, $about->getTranslation('slug', $lang) ?? '')"
                                            placeholder="{{ __('dash.Enter the slug in') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>

                                <hr class="low-opacity">

                                <div class="d-flex flex-wrap gap-5">
                                    @foreach(config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.input
                                            name="meta_title_{{ $lang }}"
                                            label="{{ __('dash.meta_title') }} ({{ __($languageName) }})"
                                            :value="old('meta_title_' . $lang, $about->getTranslation('meta_title', $lang) ?? '')"
                                            placeholder="{{ __('dash.Enter the meta title in') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    @foreach(config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.textarea
                                            name="meta_desc_{{ $lang }}"
                                            label="{{ __('dash.meta_desc') }} ({{ __($languageName) }})"
                                            :value="old('meta_desc_' . $lang, $about->getTranslation('meta_desc', $lang) ?? '')"
                                            placeholder="{{ __('dash.Enter the meta desc in') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>

                                <x-dashboard.partials.html.checkbox
                                    :name="'index'"
                                    :label="__('dash.Allow index')"
                                    :option="'Yes'"
                                    :description="__('dash.Allow index to make google robot crawling this url')"
                                    :model="$about" />

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
                <a href="{{route('about.edit')}}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">{{__('dash.Cancel')}}</a>
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
