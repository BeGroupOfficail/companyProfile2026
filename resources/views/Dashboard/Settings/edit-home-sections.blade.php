<x-dashboard.layout :title="__('dash.website_design')">
    <div id="kt_app_content" class="app-content  flex-column-fluid ">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container  container-fluid ">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Header-->
                <div class="card-header card-header-stretch overflow-auto">
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="tab-content pt-3">

                            <!--begin::Tab pane-->
                            <div class="tab-pane active show" id="tab1" role="tabpanel">

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

                            <!--end::Tab pane-->
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
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
