<!--begin::Dropzone-->
<div class="dropzone" id="kt_ecommerce_add_product_media">
    <!--begin::Message-->
    <div class="dz-message needsclick">
        <!--begin::Icon-->
        <i class="ki-outline ki-file-up text-primary fs-3x"></i> <!--end::Icon-->
        <!--begin::Info-->
        <div class="ms-4">
            <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
            <span class="fs-7 fw-semibold text-gray-500">Upload up to 10 files</span>
        </div>
        <!--end::Info-->
    </div>
</div>
<!--end::Dropzone-->

@push('scripts')
    <script>
        new Dropzone("#kt_ecommerce_add_product_media", {
            url: "https://keenthemes.com/scripts/void.php",
            paramName: "file",
            maxFiles: 10,
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            accept: function(file, done) {
                if (file.name === "wow.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            }
        });
    </script>
@endpush
