<x-dashboard.layout :title="__('dash.add_clientss')">

    <!--begin::Form-->
    <form method="post" action="{{ route('clients.store') }}" class="form d-flex flex-column flex-lg-row"
        data-kt-redirect="{{ route('clients.index') }}" enctype="multipart/form-data">
        @csrf
        <!--begin::Aside column-->
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">

            <!--begin::image-->
            <x-dashboard.partials.html.image_input :title="'Upload Image'" :name="'image'" :description="'Only *.png, *.jpg, and *.jpeg image files are accepted.'"
                :changeImageText="'Change Image'" :cancelImageText="'Cancel Image'" :removeImageText="'Remove Image'" :acceptedText="'image files are accepted'" />
            <!--end::image -->

            <!--begin::Status-->

            <x-dashboard.partials.html.status_select :model="'clients'" />

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
                            <!--begin::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">

                                <div class="d-flex flex-wrap gap-5">

                                    <x-dashboard.partials.html.select :options="$types" :name="'types'"
                                        :title="__('dash.type')" :id="'type-select'" />

                                    @foreach (config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.input name="name_{{ $lang }}"
                                            label="{{ __('dash.name') }} ({{ __($languageName) }})" :value="old('name_' . $lang, '')"
                                            placeholder="{{ __('dash.Enter the name in') }} {{ __($languageName) }}" />
                                    @endforeach

                                    <x-dashboard.partials.html.input name="link"
                                                                     label="{{ __('dash.link') }}" :value="old('link', '')"
                                                                     placeholder="{{ __('dash.Enter the link')}}" />
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    @foreach (config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.textarea name="desc_{{ $lang }}"
                                            label="{{ __('dash.desc') }} ({{ __($languageName) }})" :value="old('desc_' . $lang, '')"
                                            placeholder="{{ __('dash.Enter the desc in') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>
                            </div>
                            <!--end::Card header-->
                            <div class="d-flex flex-wrap gap-5">
                                <div class="row fv-row mb-7">
                                    <div class="col-md-6 text-md-end">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span>@lang('dash.home_publish')</span>
                                            <span class="ms-1" data-bs-toggle="tooltip">
                                                <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                            </span>
                                        </label>
                                        <!--end::Label-->
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex mt-3">
                                            <!--begin::Radio-->
                                            <div class="form-check form-check-custom form-check-solid me-5">
                                                <input class="form-check-input" type="radio" value="published"
                                                    name="home" >
                                                <label class="form-check-label" for="home_yes">@lang('dash.yes')</label>
                                            </div>

                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" value="inactive"
                                                    name="home">
                                                <label class="form-check-label" for="home_no">@lang('dash.no')</label>
                                            </div>
                                            <!--end::Radio-->
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--end::General options-->

                    </div>
                </div>
                <!--end::Tab pane-->
            </div>
            <!--end::Tab content-->

            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <a href="{{ route('clients.index') }}" id="kt_ecommerce_add_product_cancel"
                    class="btn btn-light me-5">{{ __('dash.Cancel') }}</a>
                <!--end::Button-->

                <!--begin::Button-->
                <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                    <span class="indicator-label">{{ __('dash.Save Changes') }}</span>
                    <span class="indicator-progress">{{ __('dash.Please wait...') }} <span
                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
                <!--end::Button-->
            </div>
        </div>
        <!--end::Main column-->
    </form>
    <!--end::Form-->

</x-dashboard.layout>
