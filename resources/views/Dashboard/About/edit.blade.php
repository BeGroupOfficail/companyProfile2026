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
            <x-dashboard.partials.html.image_input
                :title="'Upload Image EN'"
                :name="'image_en'"
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
            <x-dashboard.partials.html.image_input
                :title="'Upload Banner EN'"
                :name="'banner_en'"
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
