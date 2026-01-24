<script>
    function formatUrl(url) {
        return url.replace(/\/+$/, ''); // Remove trailing slashes
    }

    // Delete for individual row action
    $(document).on('click', '.btn_delete_record', function() {
        var deleteRoute = $(this).data('delete_route');
        deleteRoute = formatUrl(deleteRoute)

        var row = $(this).closest('tr');
        var data = $('.dataTable').DataTable().row(row).data(); // Get the row data
        var selectedIds = [];
        selectedIds.push(data.id); // Push the individual row's id into the array
        // Show confirmation alert before deleting
        Swal.fire({
            title: "{{__('dash.are you sure?')}}",
            text: "{{__('dash.delete this records')}}",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "{{__('dash.yes, delete it')}}!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: deleteRoute + '/' + selectedIds[
                        0], // Delete the specific item using its ID
                    type: 'DELETE',
                    data: {
                        selectedIds: selectedIds
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: "success",
                                title: "@lang('dash.deleted')",
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });

                            // Remove the row from the table
                            row.remove();
                        } else {
                            alert('@lang('dash.error_delete')');
                        }
                    },
                    error: function(error) {
                        Swal.fire({
                            title: "@lang('dash.error')",
                            text: error.responseJSON.message,
                            icon: "error"
                        });
                    }
                });
            }
        });
    });

    // Bulk Delete for selected checkboxes
    $('.btn_delete').click(function() {
        var deleteRoute = $(this).data('delete_route');
        deleteRoute = formatUrl(deleteRoute);

        var selectedCheckboxes = $("table .form-check-input:checked");
        var selectedIds = [];

        selectedCheckboxes.each(function() {
            var value = $(this).val();
            if (value !== "on") { // Exclude "on" from the selection
                selectedIds.push(value);
            }
        });

        if (selectedIds.length === 0) {
            Swal.fire({
                title: "@lang('dash.no_select')?",
                text: "@lang('dash.please_select_at_least_one')",
                icon: "warning",
                confirmButtonColor: "#5156be"
            });
        } else {
            Swal.fire({
                title: "@lang('dash.are you sure?')",
                text: "@lang('dash.delete this records')",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "@lang('dash.yes, delete it')!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: deleteRoute + '/' + selectedIds[
                            0], // Delete the specific item using its IDس
                        type: 'DELETE',
                        data: {
                            selectedIds: selectedIds
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "@lang('dash.deleted')",
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                // Remove the rows of deleted items
                                selectedCheckboxes.each(function() {
                                    $(this).closest('tr').remove();
                                });
                            } else {
                                alert('@lang('dash.error_delete')');
                            }
                        },
                        error: function(error) {
                            Swal.fire({
                                title: "@lang('dash.error')",
                                text: error.responseJSON.message,
                                icon: "error"
                            });
                        }
                    });
                }
            });
        }
    });

    // Delete for individual row action witout checkbox
    $(document).on('click', '.delete_me', function(e) {
        e.preventDefault();
        let deleteRoute = $(this).data('delete_route');
        let row = $(this).closest('tr'); // Get the row to remove it later
        let id = deleteRoute.split('/').pop();
        var selectedIds = [];
        selectedIds.push(id);
        Swal.fire({
            title: "{{__('dash.are you sure?')}}",
            text: "{{ __('dash.delete this records')}}",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "{{__('dash.yes, delete it!')}}",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteRoute,
                    type: 'DELETE',
                    data: {
                        selectedIds: selectedIds
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: "success",
                                title: "{{__('dash.deleted')}}",
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });

                            row.fadeOut(500, function() {
                                $(this).remove();
                            });

                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "{{__('dash.error')}}",
                                text: "{{__('dash.error_delete')}}"
                            });
                        }
                    },
                    error: function(error) {
                        Swal.fire({
                            title: "{{__('dash.error') }}",
                            text: error.responseJSON?.message ||
                                "An unexpected error occurred.",
                            icon: "error"
                        });
                    }
                });
            }
        });
    });
    // Delete for individual row action witout checkbox
    $(document).on('click', '.delete_me_with_refresh', function(e) {
        // ramzy
        e.preventDefault();
        let deleteRoute = $(this).data('delete_route');
        let row = $(this).closest('tr'); // Get the row to remove it later
        Swal.fire({
            title: "{{__('dash.are you sure?')}}",
            text: "{{ __('dash.delete this records')}}",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "{{__('dash.yes, delete it!')}}",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteRoute,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: "success",
                                title: "{{__('dash.deleted')}}",
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            location.reload();

                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "{{__('dash.error')}}",
                                text: "{{__('dash.error_delete')}}"
                            });
                        }
                    },
                    error: function(error) {
                        Swal.fire({
                            title: "{{__('dash.error') }}",
                            text: error.responseJSON?.message ||
                                "An unexpected error occurred.",
                            icon: "error"
                        });
                    }
                });
            }
        });
    });
</script>
<!-- /ramzy -->
