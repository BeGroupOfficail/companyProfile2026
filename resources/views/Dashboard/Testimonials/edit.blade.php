<x-dashboard.layout :title="__('dash.edit_testimonial')">

    <!--begin::Form-->
    <form method="POST" action="{{route('testimonials.update',$testimonial->id)}}" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('testimonials.index')}}" enctype="multipart/form-data">
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
                :model="$testimonial"
                :imageModelName="'testimonials'"
            />
            <!--end::image -->

            <!--begin::Status-->

            <x-dashboard.partials.html.status_select
                :model="'testimonials'"
                :selected="$testimonial->status"
                :modelObject="$testimonial"
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
                                            :value="old('title_' . $lang, $testimonial->getTranslation('title', $lang) ?? '')"
                                            placeholder="{{ __('dash.Enter the title in') }} {{ __($languageName) }}" />
                                    @endforeach

                                    <x-dashboard.partials.html.input
                                        name="rate"
                                        type="number"
                                        label="{{ __('dash.rate') }}"
                                        :value="old('rate', $testimonial->rate ??'')"
                                        placeholder="{{ __('dash.rate') }}" />
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    @foreach(config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.textarea
                                            name="text_{{ $lang }}"
                                            label="{{ __('dash.text') }} ({{ __($languageName) }})"
                                            :value="old('text_' . $lang, $testimonial->getTranslation('text', $lang) ?? '')"
                                            placeholder="{{ __('dash.Enter the text in') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.input
                                        name="author_name"
                                        label="{{ __('dash.author_name') }}"
                                        :value="old('author_name', $testimonial->author_name ??'')"
                                        placeholder="{{ __('dash.author_name') }}" />

                                    <x-dashboard.partials.html.input
                                        name="author_title"
                                        label="{{ __('dash.author_title') }}"
                                        :value="old('author_title', $testimonial->author_title ??'')"
                                        placeholder="{{ __('dash.author_title') }}" />

                                    <x-dashboard.partials.html.input
                                        name="company"
                                        label="{{ __('dash.company') }}"
                                        :value="old('company', $testimonial->company ??'')"
                                        placeholder="{{ __('dash.company') }}" />
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
                <a href="{{route('testimonials.index')}}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">{{__('dash.Cancel')}}</a>
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

    @push('scripts')
        <script>
            $(document).ready(function() {
                $(document).ready(function() {
                    // Add new FAQ section
                    $('.btn_add_record').click(function() {
                        const newFaqSection = $('.faqs-dev:first').clone();
                        newFaqSection.find('input, textarea').val('');
                        // Clear the FAQ ID for new sections
                        newFaqSection.find('input[name="faq_ids[]"]').val('');
                        newFaqSection.removeAttr('data-faq-id');

                        // Add delete functionality
                        newFaqSection.find('.btn_delete_record').click(function() {
                            deleteFaqSection($(this).closest('.faqs-dev'));
                        });

                        newFaqSection.insertBefore('.add-faq');
                    });

                    // Initialize delete button for existing FAQ sections
                    $('.btn_delete_record').click(function() {
                        deleteFaqSection($(this).closest('.faqs-dev'));
                    });

                    // Reusable function to handle FAQ deletion
                    function deleteFaqSection($faqSection) {
                        // Get the FAQ ID from the hidden input
                        const faqId = $faqSection.find('input[name="faq_ids[]"]').val();
                        const isNew = !faqId; // If no ID, it's a new FAQ

                        Swal.fire({
                            title: '{{ __("dash.are_you_sure") }}',
                            text: '{{ __("dash.delete_faq_confirmation") }}',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: '{{ __("dash.yes_delete") }}',
                            cancelButtonText: '{{ __("dash.cancel") }}'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if ($('.faqs-dev').length <= 1) {
                                    Swal.fire(
                                        '{{ __("dash.cannot_delete") }}',
                                        '{{ __("dash.at_least_one_faq_required") }}',
                                        'error'
                                    );
                                    return;
                                }

                                // If it's an existing FAQ, make AJAX call
                                if (!isNew) {
                                    $.ajax({
                                        url: '{{ route("blog-faqs.destroy") }}', // Make sure this route exists
                                        method: 'POST', // Laravel prefers POST for delete with _method
                                        data: {
                                            _token: '{{ csrf_token() }}',
                                            _method: 'DELETE',
                                            faqId: faqId
                                        },
                                        beforeSend: function() {
                                            $faqSection.addClass('deleting');
                                        },
                                        success: function(response) {
                                            $faqSection.remove();
                                            showSuccessAlert('{{ __("dash.faq_deleted_success") }}');
                                        },
                                        error: function(xhr) {
                                            $faqSection.removeClass('deleting');
                                            showErrorAlert(xhr.responseJSON?.message || '{{ __("dash.delete_failed") }}');
                                        }
                                    });
                                } else {
                                    // For new (unsaved) FAQs, just remove from DOM
                                    $faqSection.remove();
                                    showSuccessAlert('{{ __("dash.faq_deleted_success") }}');
                                }
                            }
                        });
                    }
                });

                // Helper functions for SweetAlert notifications
                function showSuccessAlert(message) {
                    Swal.fire({
                        title: '{{ __("dash.success") }}!',
                        text: message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }

                function showErrorAlert(message) {
                    Swal.fire({
                        title: '{{ __("dash.error") }}!',
                        text: message,
                        icon: 'error'
                    });
                }
            });
        </script>
    @endpush
</x-dashboard.layout>
