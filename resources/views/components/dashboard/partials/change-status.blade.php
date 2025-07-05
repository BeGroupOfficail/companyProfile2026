<script>
    function formatUrl(url) {
        return url.replace(/\/+$/, ''); // Remove trailing slashes
    }

    $(document).on('click', '.btn_active', function() {
        var modelName = $(this).data('model_name');

        var changeStatusRoute = $(this).data('change_status_route');
        changeStatusRoute = formatUrl(changeStatusRoute);

        var row = $(this).closest('tr');
        var data = $('.dataTable').DataTable().row(row).data(); // Get the row data
        var selectedIds = [];
        selectedIds.push(data.id);

        // Show confirmation alert before making the change
        Swal.fire({
            title: "@lang('dash.are_you_sure?')",
            text: "@lang('dash.change the current status')",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "@lang('dash.yes_change_status')!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Send request to change the status if the user confirmed
                $.ajax({
                    url: changeStatusRoute + '/change-status/' + selectedIds,  // Change the status based on the row's ID
                    type: 'POST',
                    data: {
                        modelName: modelName,
                        selectedIds: selectedIds,
                        _token: "{{ csrf_token() }}"  // CSRF token for security
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update the status badge in the row based on the new status
                            var statusCell = row.find('td.status-cell'); // Adjust the class if necessary
                            if (response.newStatus == 'published') {
                                statusCell.html('<div class="badge badge-light-success">' + '@lang('dash.published')' + '</div>');
                            }
                            if(response.newStatus == 'inactive') {
                                statusCell.html('<div class="badge badge-light-danger">' + '@lang('dash.inactive')' + '</div>');
                            }

                            // Optionally, you can add a success alert
                            Swal.fire({
                                icon: 'success',
                                title: '@lang('dash.status_changed')',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            alert('@lang('dash.error_change_status')');
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

    // Handle Bulk Change of Status for Selected Checkboxes
    $('.btn_change_status').click(function() {
        var modelName = $(this).data('model_name');

        var changeStatusRoute = $(this).data('change_status_route');
        changeStatusRoute = formatUrl(changeStatusRoute);

        var selectedCheckboxes = $("table .form-check-input:checked");
        var selectedIds = [];

        selectedCheckboxes.each(function() {
            selectedIds.push($(this).val());
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
                title: "@lang('dash.are_you_sure?')",
                text: "@lang('dash.change the current status')",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "@lang('dash.yes_change_status')!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: changeStatusRoute + '/change-status/' + selectedIds[0],  // Use the first selected ID for the action
                        type: 'POST',
                        data: {
                            selectedIds: selectedIds,
                            modelName: modelName,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "@lang('dash.status_changed')",
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                // Update the status of each selected row dynamically
                                selectedCheckboxes.each(function() {
                                    var row = $(this).closest('tr');
                                    var statusCell = row.find('td.status-cell');

                                    if (response.newStatus == 'published') {
                                        statusCell.html('<div class="badge badge-light-success">' + '@lang('dash.published')' + '</div>');
                                    }
                                    if(response.newStatus == 'inactive') {
                                        statusCell.html('<div class="badge badge-light-danger">' + '@lang('dash.inactive')' + '</div>');
                                    }
                                });

                                // Uncheck the selected checkboxes
                                selectedCheckboxes.each(function() {
                                    $(this).prop('checked', false);
                                });

                            } else {
                                alert('@lang('dash.error_change_status')');
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
</script>
