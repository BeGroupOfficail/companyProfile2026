<x-dashboard.layout :title="__('dash.edit_about_value')">

    <!--begin::Form-->
    <form method="POST" action="{{route('about-values.update',$aboutValue->id)}}" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('blogs.index')}}" enctype="multipart/form-data">
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
                :model="$aboutValue"
                :imageModelName="'about_values'"
            />
            <!--end::image -->

            <!--begin::icon-->
            <x-dashboard.partials.html.image_input
                :title="'Upload Icon'"
                :name="'icon'"
                :description="'Only *.png, *.jpg, and *.jpeg image files are accepted.'"
                :changeImageText="'Change Icon'"
                :cancelImageText="'Cancel Icon'"
                :removeImageText="'Remove Icon'"
                :acceptedText="'image files are accepted'"
                :model="$aboutValue"
                :imageModelName="'about_values'"
            />
            <!--end::icon -->

            <!--begin::Status-->

            <x-dashboard.partials.html.status_select
                :model="'blog'"
                :selected="$aboutValue->status"
                :modelObject="$aboutValue"
            />

            <!--end::Status-->
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
                                            :value="old('title_' . $lang, $aboutValue->getTranslation('title', $lang) ?? '')"
                                            placeholder="{{ __('dash.Enter the title in') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.select
                                        :options="$types"
                                        :name="'type'"
                                        :title="__('dash.type')"
                                        :id="'type'"
                                        :selectedValue="$aboutValue->type" />

                                    <x-dashboard.partials.html.input
                                            name="order"
                                            type="number"
                                            label="{{ __('dash.order') }}"
                                            :value="old('order', $aboutValue->order ?? '')"
                                            placeholder="{{ __('dash.order') }}" />
                                </div>

                                @foreach(config('languages') as $lang => $languageName)
                                    <x-dashboard.partials.html.textarea_with_editor
                                        name="description_{{ $lang }}"
                                        label="{{ __('dash.description') }} ({{ __($languageName) }})"
                                        :value="old('description_' . $lang, $aboutValue->getTranslation('description', $lang) ?? '')"
                                        placeholder="{{ __('dash.Enter the description in') }} {{ __($languageName) }}" />
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
                <a href="{{route('about-values.index')}}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">{{__('dash.Cancel')}}</a>
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
