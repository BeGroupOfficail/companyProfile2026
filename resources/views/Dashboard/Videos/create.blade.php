<x-dashboard.layout :title="__('dash.videos')">

    <!--begin::Form-->
    <form method="post" action="{{ route('videos.store') }}" class="form d-flex flex-column flex-lg-row"
        data-kt-redirect="{{ route('videos.index') }}" enctype="multipart/form-data">
        @csrf

        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-12">

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
                                    <div class="row fv-row mb-7">
                                        <x-dashboard.partials.html.input name="video" :required="'required'"
                                            label="{{ __('dash.video') }}" :value="old('video')"
                                            placeholder="video link" />
                                        <x-dashboard.partials.html.image_input :title="'Upload Image'" :name="'image'"
                                            :description="'Only *.png, *.jpg, and *.jpeg image files are accepted.'" :changeImageText="'Change Image'" :cancelImageText="'Cancel Image'" :removeImageText="'Remove Image'"
                                            :acceptedText="'image files are accepted'" />

                                    </div>
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
                <a href="{{ route('videos.index') }}" id="kt_ecommerce_add_product_cancel"
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
