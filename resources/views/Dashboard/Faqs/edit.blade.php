<x-dashboard.layout :title="__('dash.faqs')">

    <!--begin::Form-->
    <form method="POST" action="{{route('faqs.update')}}" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('faqs.index')}}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
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
                                @if($faqs->count() > 0)
                                    @foreach($faqs as $key=>$faq)
                                        <div class="faqs-dev">
                                            <input type="hidden" name="faq_ids[]" value="{{ $faq->id }}">
                                            <div class="d-flex flex-wrap gap-5">
                                                @foreach(config('languages') as $lang => $languageName)
                                                    <x-dashboard.partials.html.input
                                                        name="question_{{ $lang }}[]"
                                                        label="{{ __('dash.question') }} ({{ __($languageName) }})"
                                                        :value="old('question_' . $lang, $faq->getTranslation('question', $lang) ?? '')"
                                                        placeholder="{{ __('dash.Enter the question in') }} {{ __($languageName) }}" />
                                                @endforeach
                                            </div>

                                            <div class="d-flex flex-wrap gap-5">
                                                @foreach(config('languages') as $lang => $languageName)
                                                    <x-dashboard.partials.html.textarea
                                                        name="answer_{{ $lang }}[]"
                                                        label="{{ __('dash.answer') }} ({{ __($languageName) }})"
                                                        :value="old('answer_' . $lang, $faq->getTranslation('answer', $lang) ?? '')"
                                                        placeholder="{{ __('dash.Enter the answer in') }} {{ __($languageName) }}" />
                                                @endforeach
                                            </div>

                                            <div>
                                                <a href="javascript:;" class="btn btn-icon btn-flex btn-light-danger w-30px h-30px me-3 btn_delete_record" title="{{ trans('dash.delete') }}" data-delete_route="{{ isset($routeName)?route( $routeName.'.index'):'' }}" title="{{ __('dash.delete') }}">
                                                    <i class="ki-outline ki-trash fs-2"></i>
                                                </a>
                                                <hr class="low-opacity">
                                            </div>

                                        </div>
                                    @endforeach

                                    <div class="add-faq">
                                        <a href="javascript:;" class="btn btn-light-primary me-5 btn_add_record" title="{{ trans('dash.add') }}" title="{{ __('dash.add') }}">
                                            {{ __('dash.add') }}  <i class="ki-outline ki-plus fs-2"></i>
                                        </a>
                                    </div>
                                @else
                                    <div class="faqs-dev">
                                        <div class="d-flex flex-wrap gap-5">
                                            <input type="hidden" name="faq_ids[]" value="">
                                            @foreach(config('languages') as $lang => $languageName)
                                                <x-dashboard.partials.html.input
                                                    name="question_{{ $lang }}[]"
                                                    label="{{ __('dash.question') }} ({{ __($languageName) }})"
                                                    placeholder="{{ __('dash.Enter the question in') }} {{ __($languageName) }}" />
                                            @endforeach

                                            <x-dashboard.partials.html.select
                                                :options="['published'=>'published','inactive'=>'inactive']"
                                                :name="'status[]'"
                                                :title="__('dash.status')"
                                                :id="'status-select'" />
                                        </div>

                                        <div class="d-flex flex-wrap gap-5">
                                            @foreach(config('languages') as $lang => $languageName)
                                                <x-dashboard.partials.html.textarea
                                                    name="answer_{{ $lang }}[]"
                                                    label="{{ __('dash.answer') }} ({{ __($languageName) }})"
                                                    placeholder="{{ __('dash.Enter the answer in') }} {{ __($languageName) }}" />
                                            @endforeach
                                        </div>

                                        <div>
                                            <a href="javascript:;" class="btn btn-icon btn-flex btn-light-danger w-30px h-30px me-3 btn_delete_record" title="{{ trans('dash.delete') }}" data-delete_route="{{ isset($routeName)?route( $routeName.'.index'):'' }}" title="{{ __('dash.delete') }}">
                                                <i class="ki-outline ki-trash fs-2"></i>
                                            </a>
                                            <hr class="low-opacity">
                                        </div>
                                    </div>

                                    <div class="add-faq">
                                        <a href="javascript:;" class="btn btn-light-primary me-5 btn_add_record" title="{{ trans('dash.add') }}" title="{{ __('dash.add') }}">
                                            {{ __('dash.add') }}  <i class="ki-outline ki-plus fs-2"></i>
                                        </a>
                                    </div>
                                @endif

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

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Add new FAQ section
                $('.btn_add_record').click(function() {
                    const newFaqSection = $('.faqs-dev:first').clone();

                    // Clear input, textarea, and select values
                    newFaqSection.find('input, textarea').val('');

                    // Ensure only one select element exists and reset it
                    const $selects = newFaqSection.find('select[name="status[]"]');
                    if ($selects.length > 1) {
                        // Keep only the first select and remove others
                        $selects.slice(1).remove();
                    }
                    const $select = $selects.first();
                    $select.val(''); // Reset select to no selection

                    // Clear the FAQ ID for new sections
                    newFaqSection.find('input[name="faq_ids[]"]').val('');

                    // Remove any data attributes from the cloned section
                    newFaqSection.removeAttr('data-faq-id');

                    // Generate a unique ID for the select element
                    const uniqueId = 'status-select-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
                    $select.attr('id', uniqueId);

                    // Remove any existing select enhancements (e.g., Select2)
                    if ($select.hasClass('select2-hidden-accessible')) {
                        $select.select2('destroy'); // Destroy Select2 instance
                    }
                    newFaqSection.find('.select2-container').remove(); // Remove Select2 wrapper

                    // Reinitialize Select2 if present
                    if (typeof $.fn.select2 !== 'undefined') {
                        $select.select2({
                            placeholder: '{{ __("dash.select_status") }}',
                            allowClear: true
                        });
                    }

                    // Remove existing event handlers to prevent duplicate bindings
                    newFaqSection.find('.btn_delete_record').off('click');

                    // Add delete functionality for the new section
                    newFaqSection.find('.btn_delete_record').click(function() {
                        deleteFaqSection($(this).closest('.faqs-dev'));
                    });

                    // Insert the new FAQ section before the "Add FAQ" button
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
                                    url: '{{ route("blog-faqs.destroy") }}',
                                    method: 'POST',
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

                // Ensure existing FAQs have unique select IDs and initialize Select2
                $('.faqs-dev').each(function(index) {
                    const uniqueId = 'status-select-existing-' + index;
                    const $selects = $(this).find('select[name="status[]"]');
                    if ($selects.length > 1) {
                        // Keep only the first select and remove others
                        $selects.slice(1).remove();
                    }
                    const $select = $selects.first();
                    $select.attr('id', uniqueId);

                    // Initialize Select2 for existing FAQs if present
                    if (typeof $.fn.select2 !== 'undefined') {
                        $select.select2({
                            placeholder: '{{ __("dash.select_status") }}',
                            allowClear: true
                        });
                    }
                });
            });
        </script>
    @endpush
</x-dashboard.layout>
