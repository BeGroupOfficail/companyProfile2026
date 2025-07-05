<x-dashboard.layout :title="__('dash.website_design')">
    <div id="kt_app_content" class="app-content  flex-column-fluid ">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container  container-fluid ">
            <!--begin::Layout Builder Notice-->
            <div class="card mb-10">
                <div class="card-body d-flex align-items-center p-5 p-lg-8">
                    <!--begin::Icon-->
                    <div class="d-flex h-50px w-50px h-lg-80px w-lg-80px flex-shrink-0 flex-center position-relative align-self-start align-self-lg-center mt-3 mt-lg-0">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="text-primary h-75px w-75px h-lg-100px w-lg-100px position-absolute opacity-5">
                            <path fill="currentColor" d="M10.2,21.23,4.91,18.17a3.58,3.58,0,0,1-1.8-3.11V8.94a3.58,3.58,0,0,1,1.8-3.11L10.2,2.77a3.62,3.62,0,0,1,3.6,0l5.29,3.06a3.58,3.58,0,0,1,1.8,3.11v6.12a3.58,3.58,0,0,1-1.8,3.11L13.8,21.23A3.62,3.62,0,0,1,10.2,21.23Z"></path>
                        </svg>

                        <i class="ki-outline ki-wrench fs-2x fs-lg-3x text-primary position-absolute"></i>
                    </div>
                    <!--end::Icon-->

                    <!--begin::Description-->
                    <div class="ms-6">
                        <p class="list-unstyled text-gray-600 fw-semibold fs-6 p-0 m-0">
                            @lang('dash.The layout builder is to assist your set and configure your preferred project layout specifications and preview it in real time and export the HTML template with its includable partials of this demo. The downloaded version does not include the assets folder since the layout builders main purpose is to help to generate the final HTML code without hassle.')
                        </p>
                    </div>
                    <!--end::Description-->
                </div>
            </div>
            <!--end::Layout Builder Notice-->

            <!--begin::Card-->
            <div class="card">
                <!--begin::Header-->
                <div class="card-header card-header-stretch overflow-auto">
                    <!--begin::Tabs-->
                    <ul class="nav nav-stretch nav-line-tabs fw-semibold fs-6 border-transparent flex-nowrap" role="tablist" id="kt_layout_builder_tabs">

{{--                        <li class="nav-item" role="presentation">--}}
{{--                            <a class="nav-link active" data-bs-toggle="tab" href="#tab1" role="tab" aria-selected="true">@lang('dash.choose design layout') </a>--}}
{{--                        </li>--}}

                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tab2" role="tab" aria-selected="false" tabindex="-1">@lang('dash.home page sections') </a>
                        </li>
                    </ul>
                    <!--end::Tabs-->
                </div>
                <!--end::Header-->

                <!--begin::Form-->
                <form class="form" method="POST" id="kt_layout_builder_form" action="{{route('settings.update-website-designs')}}">
                    @csrf
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="tab-content pt-3">

{{--                            <!--begin::Tab pane-->--}}
{{--                            <div class="tab-pane active show" id="tab1" role="tabpanel">--}}

{{--                                <!--begin::Form group-->--}}
{{--                                <div class="form-group">--}}
{{--                                    <!--begin::Heading-->--}}
{{--                                    <div class="mb-6">--}}
{{--                                        <h4 class="fw-bold text-gray-900">@lang('dash.website_designs')</h4>--}}
{{--                                        <div class="fw-semibold text-muted fs-7 d-block lh-1">@lang('dash.click to choose the default layout')</div>--}}
{{--                                    </div>--}}
{{--                                    <!--end::Heading-->--}}

{{--                                    <!--begin::Options-->--}}
{{--                                    <div class="row mw-lg-600px" data-kt-buttons="true" data-kt-buttons-target=".form-check-image,.form-check-input" data-kt-initialized="1">--}}
{{--                                        @foreach($websiteDesigns as $key=>$websiteDesign)--}}
{{--                                            <!--begin::Col-->--}}
{{--                                            <div class="col-6">--}}
{{--                                                <!--begin::Option-->--}}
{{--                                                <label class="form-check-image form-check-success @if($websiteDesign->is_active == 1) active @endif">--}}
{{--                                                    <!--begin::Image-->--}}
{{--                                                    <div class="form-check-wrapper border-gray-200 border-2">--}}
{{--                                                        <img src="{{Path::uploadedImage('website-designs',$websiteDesign->image)}}" class="form-check-rounded mw-100" alt="{{$websiteDesign->alt_image}}">--}}
{{--                                                    </div>--}}
{{--                                                    <!--end::Image-->--}}

{{--                                                    <!--begin::Check-->--}}
{{--                                                    <div class="form-check form-check-custom form-check-solid form-check-sm form-check-success">--}}
{{--                                                        <input class="form-check-input" type="radio" value="{{$websiteDesign->id}}" name="website_design_id" @if($websiteDesign->is_active == 1) checked @endif>--}}
{{--                                                        <!--begin::Label-->--}}
{{--                                                        <div class="form-check-label text-gray-700">{{$websiteDesign->name}} </div>--}}
{{--                                                        <!--end::Label-->--}}
{{--                                                    </div>--}}
{{--                                                    <!--end::Check-->--}}
{{--                                                </label>--}}
{{--                                                <!--end::Option-->--}}
{{--                                            </div>--}}
{{--                                            <!--end::Col-->--}}
{{--                                        @endforeach--}}


{{--                                    </div>--}}
{{--                                    <!--end::Options-->--}}
{{--                                </div>--}}
{{--                                <!--end::Form group-->--}}

{{--                            </div>--}}
{{--                            <!--end::Tab pane-->--}}

                            <!--begin::Tab pane-->
                            <div class="tab-pane active show" id="tab2" role="tabpanel">

                                <div id="sortable-sections">
                                    @foreach($homePageSections as $key => $homePageSection)
                                        <!--begin::Sortable item-->
                                        <div class="sortable-item" data-id="{{ $homePageSection->id }}">
                                            <!--begin::Form group-->
                                            <div class="form-group d-flex flex-stack">
                                                <!--begin::Heading-->
                                                <div class="d-flex flex-column">
                                                    <h4 class="fw-bold text-gray-900">{{ $homePageSection->getTranslation('title', $lang) }}</h4>
                                                    <div class="fs-7 fw-semibold text-muted">
                                                        @lang('dash.select to publish content')
                                                    </div>
                                                </div>
                                                <!--end::Heading-->

                                                <div class="order-form" data-id="{{ $homePageSection->id }}">
                                                    <span class="text-muted">@lang('dash.if you need to reorder drag and drop')</span>
                                                </div>

                                                <!--begin::Option-->
                                                <div class="d-flex justify-content-end">
                                                    <!--begin::Check-->
                                                    <div class="form-check form-check-custom form-check-solid form-check-success form-switch">
                                                        <input class="form-check-input w-45px h-30px" type="checkbox" value="{{ $homePageSection->id }}" name="selectedSectionIds[]" @if($homePageSection->is_active == 1) checked @endif>
                                                    </div>
                                                    <!--end::Check-->
                                                </div>
                                                <!--end::Option-->
                                            </div>
                                            <!--end::Form group-->

                                            <div class="separator separator-dashed my-6"></div>
                                        </div>
                                        <!--end::Sortable item-->
                                    @endforeach
                                </div>

                            </div>
                            <!--end::Tab pane-->
                        </div>
                    </div>
                    <!--end::Body-->

                    <!--begin::Footer-->

                    <div class="card-footer d-flex py-8">
                        <!--begin::Button-->
                        <a href="{{route('dashboard.home')}}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">{{__('dash.Cancel')}}</a>
                        <!--end::Button-->

                        <!--begin::Button-->
                        <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                            <span class="indicator-label">{{__('dash.Save Changes')}}</span>
                            <span class="indicator-progress">{{__('dash.Please wait...')}} <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                    </div>
                    <!--end::Footer-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
    </div>

    @push('scripts')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize Sortable.js on the container that holds the rows
                const sortable = new Sortable(document.getElementById('sortable-sections'), {
                    handle: '.order-form', // Allows dragging from this area
                    animation: 150, // Smooth dragging animation
                    filter: '.separator', // Prevent separators from being draggable on their own
                    onEnd(evt) {
                        // Call the function to update the order when the rows are rearranged
                        updateOrder(evt);
                    }
                });
            });

            function updateOrder(evt) {
                // Capture the new order of the items
                const orderedSections = Array.from(evt.from.querySelectorAll('.sortable-item')).map(item => item.getAttribute('data-id'));

                // Send the new order to the server
                const url = '{{route('settings.update-section-order')}}'; // Replace with your backend URL
                const formData = new FormData();
                formData.append('orderedSections', JSON.stringify(orderedSections));
                formData.append('_token', document.querySelector('input[name="_token"]').value);

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Order updated successfully!');
                            // Optionally reload the page or update UI
                            // location.reload();
                        } else {
                            console.error('Failed to update order:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error updating order:', error);
                    });
            }
        </script>
    @endpush
</x-dashboard.layout>
