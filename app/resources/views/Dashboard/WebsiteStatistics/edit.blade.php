<x-dashboard.layout :title="__('dash.edit_websiteStatistic')">

    <!--begin::Form-->
    <form method="POST" action="{{route('website-statistics.update',$websiteStatistic->id)}}" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('website-statistics.index')}}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <!--begin::Aside column-->
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <!--begin::image-->
            <x-dashboard.partials.html.image_input
                :title="'Upload image'"
                :name="'image'"
                :description="'Only *.png, *.jpg, and *.jpeg icon files are accepted.'"
                :changeImageText="'Change image'"
                :cancelImageText="'Cancel image'"
                :removeImageText="'Remove image'"
                :acceptedText="'icon files are accepted'"
                :model="$websiteStatistic"
                :imageModelName="'websiteStatistic'"
            />
            <!--end::image -->

            <!--begin::Status-->
            <x-dashboard.partials.html.status_select
                :model="'websiteStatistics'"
                :selected="$websiteStatistic->status"
                :modelObject="$websiteStatistic"
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
                                            :value="old('title_' . $lang, $websiteStatistic->getTranslation('title', $lang) ?? '')"
                                            placeholder="{{ __('dash.Enter the title in') }} {{ __($languageName) }}" />
                                    @endforeach

                                    <x-dashboard.partials.html.input
                                        name="count"
                                        type="number"
                                        label="{{ __('dash.count') }}"
                                        :value="old('count', $websiteStatistic->count ??'')"
                                        placeholder="{{ __('dash.count') }}" />
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
                <a href="{{route('website-statistics.index')}}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">{{__('dash.Cancel')}}</a>
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
