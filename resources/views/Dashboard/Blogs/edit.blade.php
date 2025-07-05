<x-dashboard.layout :title="__('dash.edit_blog')">

    <!--begin::Form-->
    <form method="POST" action="{{route('blogs.update',$blog->id)}}" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('blogs.index')}}" enctype="multipart/form-data">
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
                :model="$blog"
                :imageModelName="'blogs'"
            />
            <!--end::image -->

            <!--begin::Status-->

            <x-dashboard.partials.html.status_select
                :model="'blog'"
                :selected="$blog->status"
                :modelObject="$blog"
            />

            <!--end::Status-->
        </div>
        <!--end::Aside column-->

        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#tab1">{{ __('dash.main info') }}</a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#tab2">{{ __('dash.faqs') }}</a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#tab3">{{ __('dash.seo info') }}</a>
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
                                    <x-dashboard.partials.html.objects-select
                                        name="blog_category_id"
                                        title="{{ __('dash.blog_category') }}"
                                        :options="$blogCategories"
                                        :isTranslatable="true"
                                        :translatableValue="'name'"
                                        :selectedValue="$blog->blog_category_id"/>

                                    @foreach(config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.input
                                            name="name_{{ $lang }}"
                                            label="{{ __('dash.name') }} ({{ __($languageName) }})"
                                            :value="old('name_' . $lang, $blog->getTranslation('name', $lang) ?? '')"
                                            placeholder="{{ __('dash.Enter the name in') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    @foreach(config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.textarea
                                            name="short_desc_{{ $lang }}"
                                            label="{{ __('dash.short_desc') }} ({{ __($languageName) }})"
                                            :value="old('short_desc_' . $lang, $blog->getTranslation('short_desc', $lang) ?? '')"
                                            placeholder="{{ __('dash.Enter the short dec in') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>

                                @foreach(config('languages') as $lang => $languageName)
                                    <x-dashboard.partials.html.textarea_with_editor
                                        name="long_desc_{{ $lang }}"
                                        label="{{ __('dash.long_desc') }} ({{ __($languageName) }})"
                                        :value="old('long_desc_' . $lang, $blog->getTranslation('long_desc', $lang) ?? '')"
                                        placeholder="{{ __('dash.Enter the long dec in') }} {{ __($languageName) }}" />
                                @endforeach

                                <div class="d-flex flex-wrap gap-5">
                                    <div class="row fv-row mb-7">
                                        <div class="col-md-6 text-md-end">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>@lang('dash.home_publish')</span>
                                                <span class="ms-1" data-bs-toggle="tooltip" >
                                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                </span>
                                            </label>
                                            <!--end::Label-->
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex mt-3">
                                                <!--begin::Radio-->
                                                <div class="form-check form-check-custom form-check-solid me-5">
                                                    <input class="form-check-input" type="radio" value="1" name="home" @checked($blog->home == 1) >
                                                    <label class="form-check-label" for="home_yes">@lang('dash.yes')</label>
                                                </div>

                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" value="0" name="home" @checked($blog->home == 0)>
                                                    <label class="form-check-label" for="home_no">@lang('dash.no')</label>
                                                </div>
                                                <!--end::Radio-->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <div class="row fv-row mb-7">
                                        <div class="col-md-6 text-md-end">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span>@lang('dash.menu_publish')</span>
                                                <span class="ms-1" data-bs-toggle="tooltip" >
                                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                </span>
                                            </label>
                                            <!--end::Label-->
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex mt-3">
                                                <!--begin::Radio-->
                                                <div class="form-check form-check-custom form-check-solid me-5">
                                                    <input class="form-check-input" type="radio" value="1" name="menu" @checked($blog->menu == 1)>
                                                    <label class="form-check-label" for="header_yes">@lang('dash.yes')</label>
                                                </div>

                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" value="0" name="menu" @checked($blog->menu == 0)>
                                                    <label class="form-check-label" for="header_no">@lang('dash.no')</label>
                                                </div>
                                                <!--end::Radio-->
                                            </div>
                                        </div>
                                    </div>
                                </div>

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

                        <!--begin::General options-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>{{ __('dash.faqs') }} </h2>
                                </div>
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                @if($blog->blogFaqs()->count() > 0)
                                    @foreach($blog->blogFaqs as $key=>$blogFaq)
                                        <div class="faqs-dev">
                                            <input type="hidden" name="faq_ids[]" value="{{ $blogFaq->id }}">
                                            <div class="d-flex flex-wrap gap-5">
                                                @foreach(config('languages') as $lang => $languageName)
                                                    <x-dashboard.partials.html.input
                                                        name="question_{{ $lang }}[]"
                                                        label="{{ __('dash.question') }} ({{ __($languageName) }})"
                                                        :value="old('question_' . $lang, $blogFaq->getTranslation('question', $lang) ?? '')"
                                                        placeholder="{{ __('dash.Enter the question in') }} {{ __($languageName) }}" />
                                                @endforeach
                                            </div>

                                            <div class="d-flex flex-wrap gap-5">
                                                @foreach(config('languages') as $lang => $languageName)
                                                    <x-dashboard.partials.html.textarea
                                                        name="answer_{{ $lang }}[]"
                                                        label="{{ __('dash.answer') }} ({{ __($languageName) }})"
                                                        :value="old('answer_' . $lang, $blogFaq->getTranslation('answer', $lang) ?? '')"
                                                        placeholder="{{ __('dash.Enter the answer in') }} {{ __($languageName) }}" />
                                                @endforeach
                                            </div>

                                            <div>
                                                <a href="javascript:;" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm btn_delete_record" title="{{ trans('dash.delete') }}" data-delete_route="{{ isset($routeName)?route( $routeName.'.index'):'' }}" title="{{ __('dash.delete') }}">
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
                                            <a href="javascript:;" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm btn_delete_record" title="{{ trans('dash.delete') }}" data-delete_route="{{ isset($routeName)?route( $routeName.'.index'):'' }}" title="{{ __('dash.delete') }}">
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

                <!--begin::Tab pane-->
                <div class="tab-pane" id="tab3" role="tab-panel">
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
                                            :value="old('slug_' . $lang, $blog->getTranslation('slug', $lang) ?? '')"
                                            placeholder="{{ __('dash.Enter the slug in') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>

                                <hr class="low-opacity">

                                <div class="d-flex flex-wrap gap-5">
                                    @foreach(config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.input
                                            name="meta_title_{{ $lang }}"
                                            label="{{ __('dash.meta_title') }} ({{ __($languageName) }})"
                                            :value="old('meta_title_' . $lang, $blog->getTranslation('meta_title', $lang) ?? '')"
                                            placeholder="{{ __('dash.Enter the meta title in') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    @foreach(config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.textarea
                                            name="meta_desc_{{ $lang }}"
                                            label="{{ __('dash.meta_desc') }} ({{ __($languageName) }})"
                                            :value="old('meta_desc_' . $lang, $blog->getTranslation('meta_desc', $lang) ?? '')"
                                            placeholder="{{ __('dash.Enter the meta desc in') }} {{ __($languageName) }}" />
                                    @endforeach
                                </div>

                                <x-dashboard.partials.html.checkbox
                                    :name="'index'"
                                    :label="__('dash.Allow index')"
                                    :option="'Yes'"
                                    :description="__('dash.Allow index to make google robot crawling this url')"
                                    :model="$blog" />

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
                <a href="{{route('blogs.index')}}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">{{__('dash.Cancel')}}</a>
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
