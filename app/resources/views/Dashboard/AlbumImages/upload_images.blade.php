<x-dashboard.layout :title="__('dash.upload files')">
    @push('styles')
        <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    @endpush

    <form method="post" action="{{route('albums.album-images.store',$album->id)}}" data-kt-redirect="" enctype="multipart/form-data">
        @csrf
        <div class="card card-flush mb-5">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>@lang('dash.upload album') {{$album->getTranslation('title',$lang)}} @lang('dash.images')</h2>
                </div>
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Input group-->
                <div class="fv-row mb-2">
                    <x-dropzone-uploader
                        uploadUrl="{{ route('albums.album-images.upload') }}"
                        removeUrl="{{ route('albums.album-images.remove') }}"
                        type="album_images"
                        elementId="kt_ecommerce_add_product_media"
                    />

                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card header-->

            <div class="d-flex justify-content-end m-7">
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
    </form>

    <div class="card card-flush">
        <!--begin::Card body-->
        <div class="card-body ">

            <!--begin::Table-->
            <div id="kt_ecommerce_category_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                @if(count($album->images) > 0)
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable sortable" id="kt_ecommerce_category_table" style="width: 100%;">
                            <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-250px">@lang('dash.image')</th>
                                <th class="min-w-100px">@lang('dash.order')</th>
                                <th class="min-w-150px">@lang('dash.status')</th>
                                <th class="text-end">@lang('dash.actions')</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            @foreach($album->images as $key=>$image)
                                <tr id="image-{{ $image->id }}" data-id="{{ $image->id }}" class="image">
                                    <td>
                                        <div class="d-flex">


                                            <a href="{{ asset("uploads/album_images/$image->image") }}" data-lightbox="gallery" data-title="Image Preview" class="symbol symbol-175px">
                                                <span class="symbol-label" style="background-image:url({{ asset("uploads/album_images/$image->image") }})"></span>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <form class="order-form" data-id="{{ $image->id }}">
                                            <span class="text-muted">@lang('dash.if you need to reorder type then click out')</span>
                                            @csrf
                                            <input type="number"
                                                   name="order"
                                                   value="{{ $image->order }}"
                                                   class="form-control form-control-sm order-input"
                                                   style="width: 80px;"
                                                   min="1"
                                                   data-update-url="{{ route('albums.album-images.update-order', $image->id) }}">
                                        </form>
                                    </td>
                                    <td>
                                        @if($image->status == 'published')
                                            <div class="badge badge-light-success">@lang('dash.published')</div>
                                        @else
                                            <div class="badge badge-light-danger">@lang('dash.inactive')</div>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="javascript:;"
                                           class="btn btn-icon btn-bg-light btn-active-color-info btn-sm me-1 btn_change_status"
                                           data-id="{{ $image->id }}"
                                           data-current-status="{{ $image->status }}"
                                           data-update-url="{{ route('albums.album-images.change-status', $image->id) }}">
                                            <i class="ki-outline ki-switch fs-2"></i>
                                        </a>

                                        <a href="javascript:;"
                                           class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm btn_delete_file"
                                           data-id="{{ $image->id }}"
                                           data-delete_route="{{ route('albums.album-images.destroy', $image->id) }}">
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
                        <h3>@lang('dash.no images uploads to this album')</h3>
                    </div>
                @endif

            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>

    @push('scripts')
        <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
        <script>
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true
            });
        </script>

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
