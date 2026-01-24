<x-dashboard.layout :title="__('dash.upload videos')">

    <!--begin::Form-->
    <form method="post" action="{{route('albums.album-videos.store',$album->id)}}" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('albums.edit',$album->id)}}" enctype="multipart/form-data">
        @csrf
        <!--begin::Aside column-->
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">

            <!--begin::Status-->
            <x-dashboard.partials.html.status_select
                :model="'lesson'"
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

                                    <x-dashboard.partials.html.input
                                        name="video_url"
                                        label="{{ __('dash.video_url') }}"
                                        :value="old('video_url', '')"
                                        placeholder="{{ __('dash.video_url') }} " />

                                    <x-dashboard.partials.html.input
                                        name="order"
                                        type="number"
                                        label="{{ __('dash.order') }}"
                                        :value="old('order', '')"
                                        placeholder="{{ __('dash.order') }}" />

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

            <div class="d-flex justify-content-end mb-5">
                <!--begin::Button-->
                <a href="{{route('albums.edit',$album->id)}}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">{{__('dash.Cancel')}}</a>
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

    <div class="card card-flush">
        <!--begin::Card body-->
        <div class="card-body ">

            <!--begin::Table-->
            <div id="kt_ecommerce_category_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                @if(count($album->videos) > 0)
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable sortable" id="kt_ecommerce_category_table" style="width: 100%;">
                            <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-250px">@lang('dash.video')</th>
                                <th class="min-w-100px">@lang('dash.order')</th>
                                <th class="min-w-150px">@lang('dash.status')</th>
                                <th class="text-end">@lang('dash.actions')</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            @foreach($album->videos as $key=>$video)
                                <tr id="image-{{ $video->id }}" data-id="{{ $video->id }}" class="image">
                                    <td>
                                        <div class="d-flex">
                                            <div class="symbol symbol-175px">
                                                <iframe src="{{$video->video_url}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <form class="order-form" data-id="{{ $video->id }}">
                                            <span>@lang('dash.if you need to reorder type then click out')</span>
                                            @csrf
                                            <input type="number"
                                                   name="order"
                                                   value="{{ $video->order }}"
                                                   class="form-control form-control-sm order-input"
                                                   style="width: 80px;"
                                                   min="1"
                                                   data-update-url="{{ route('albums.album-videos.update-order', $video->id) }}">
                                        </form>
                                    </td>
                                    <td>
                                        @if($video->status == 'published')
                                            <div class="badge badge-light-success">@lang('dash.published')</div>
                                        @else
                                            <div class="badge badge-light-danger">@lang('dash.inactive')</div>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="javascript:;"
                                           class="btn btn-icon btn-bg-light btn-active-color-info btn-sm me-1 btn_change_status"
                                           data-id="{{ $video->id }}"
                                           data-current-status="{{ $video->status }}"
                                           data-update-url="{{ route('albums.album-videos.change-status', $video->id) }}">
                                            <i class="ki-outline ki-switch fs-2"></i>
                                        </a>

                                        <a href="javascript:;"
                                           class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm btn_delete_file"
                                           data-id="{{ $video->id }}"
                                           data-delete_route="{{ route('albums.album-videos.destroy', $video->id) }}">
                                            <i class="ki-outline ki-trash fs-2"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="justify-content-center d-flex align-item-center">
                        <h3>@lang('dash.no videos uploads to this album')</h3>
                    </div>
                @endif

            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>

    @push('scripts')

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Handle order changes when input loses focus or Enter is pressed
                document.querySelectorAll('.order-input').forEach(input => {
                    input.addEventListener('change', function() {
                        updateImageOrder(this);
                    });

                    input.addEventListener('keyup', function(e) {
                        if (e.key === 'Enter') {
                            updateImageOrder(this);
                        }
                    });
                });
            });

            function updateImageOrder(input) {
                const form = input.closest('form');
                const url = input.dataset.updateUrl;
                const data = new FormData(form);

                fetch(url, {
                    method: 'POST',
                    body: data,
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(data => {
                    location.reload();
                })
            }
        </script>

        <script>
            /// delete btn //
            $(document).on('click', '.btn_delete_file', function() {
                var deleteRoute = $(this).data('delete_route');
                var row = $(this).closest('tr'); // Get the entire table row

                Swal.fire({
                    title: "{{__('dash.are_you_sure')}}",
                    text: "{{__('dash.delete_this_record')}}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "{{__('dash.yes_delete_it')}}",
                    cancelButtonText: "{{__('dash.cancel')}}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteRoute,
                            type: 'DELETE',
                            dataType: 'json',  // Explicitly expect JSON
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'Accept': 'application/json'
                            },
                            success: function(response) {
                                console.log('Response received:', response);

                                // Check multiple possible success indicators
                                if ((response.success === true) || (response.status === 'success')) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "{{__('dash.deleted')}}",
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    row.fadeOut(300, function() {
                                        $(this).remove();
                                        // Re-number rows if needed
                                        $('tbody tr').each(function(index) {
                                            $(this).find('.order-input').val(index + 1);
                                        });
                                    });
                                } else {
                                    Swal.fire({
                                        title: "{{__('dash.error')}}",
                                        text: response.message || 'Unknown error occurred',
                                        icon: "error"
                                    });
                                }
                            },
                            error: function(xhr) {
                                console.error('AJAX error:', xhr);
                                let errorMsg = "{{__('dash.unexpected_error')}}";

                                try {
                                    const jsonResponse = JSON.parse(xhr.responseText);
                                    errorMsg = jsonResponse.message || errorMsg;
                                } catch (e) {
                                    errorMsg = xhr.statusText || errorMsg;
                                }

                                Swal.fire({
                                    title: "{{__('dash.error')}}",
                                    text: errorMsg,
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });

            /// change status btn ///

            $(document).on('click', '.btn_change_status', function() {
                const button = $(this);
                const updateUrl = button.data('update-url');
                const currentStatus = button.data('current-status');
                const row = button.closest('tr');

                // Show loading indicator on the button
                button.prop('disabled', true);
                button.find('i').addClass('fa-spin');

                $.ajax({
                    url: updateUrl,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update the status badge in the table
                            const statusCell = row.find('td:nth-child(3)'); // Adjust index if needed
                            statusCell.html(`
                    <div class="badge ${response.status_class}">
                        ${response.status_label}
                    </div>
                `);

                            // Update the button's current status data attribute
                            button.data('current-status', response.new_status);

                            // Show success message
                            Swal.fire({
                                icon: "success",
                                title: "{{__('dash.success')}}",
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            Swal.fire({
                                title: "{{__('dash.error')}}",
                                text: response.message,
                                icon: "error"
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = "{{__('dash.unexpected_error')}}";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            title: "{{__('dash.error')}}",
                            text: errorMsg,
                            icon: "error"
                        });
                    },
                    complete: function() {
                        // Re-enable the button
                        button.prop('disabled', false);
                        button.find('i').removeClass('fa-spin');
                    }
                });
            });


        </script>
    @endpush
</x-dashboard.layout>
