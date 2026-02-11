<x-dashboard.layout :title="__('dash.menu_items')">

    <!--begin::Card-->
    <div class="card">

        <x-dashboard.partials.card_header :title="'menu_items'" :routeName="'menu-items'" :modelName="'menu_items'" />

        <!--begin::Card body-->
        <div class="card-body py-4">

            <!--begin::Table-->
            <div class="dt-container dt-bootstrap5 dt-empty-footer">
                <div class="table-responsive">
                    {{ $dataTable->table() }}
                </div>
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

    @push('scripts')
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
    // Wait for DataTable to be fully initialized
    $(document).ready(function() {
        // Get the DataTable instance
        let table = $('#menu-items-table').DataTable();

        // Wait a bit more to ensure DataTable is fully rendered
            initializeSortable();

        function initializeSortable() {
            // Destroy existing sortable if it exists
            if ($('#menu-items-table tbody').hasClass('ui-sortable')) {
                $('#menu-items-table tbody').sortable('destroy');
            }

            // Initialize sortable on the tbody
            $('#menu-items-table tbody').sortable({
                handle: '.drag-handle',
                placeholder: 'ui-state-highlight',
                axis: 'y', // Only allow vertical sorting
                containment: 'parent',
                tolerance: 'pointer',
                cursor: 'move',
                helper: function(e, tr) {
                    var $originals = tr.children();
                    var $helper = tr.clone();
                    $helper.children().each(function(index) {
                        $(this).width($originals.eq(index).width());
                    });
                    $helper.addClass('dragging-row');
                    return $helper;
                },
                start: function(event, ui) {
                    ui.placeholder.height(ui.item.height());
                    ui.placeholder.html('<td colspan="' + ui.item.find('td').length + '" class="sorting-placeholder">Moving...</td>');
                    ui.item.addClass('dragging');
                },
                stop: function(event, ui) {
                    ui.item.removeClass('dragging');
                },
                update: function(event, ui) {
                    var order = [];
                    $('#menu-items-table tbody tr').each(function(index) {
                        // Get the row ID from data-id attribute or id attribute
                        var itemId = $(this).data('id') || $(this).attr('id');
                        if (itemId) {
                            // Remove any prefix from the ID if DataTables adds one
                            var cleanId = itemId.toString().replace('menu-items-table_', '');
                            order.push({
                                id: cleanId,
                                order: index + 1
                            });
                        }
                    });


                    if (order.length > 0) {
                        updateMenuItemOrder(order);
                    }
                }
            });
        }

        // Re-initialize sortable after DataTable redraws
        table.on('draw', function() {
                initializeSortable();
        });

        // Re-initialize sortable after page changes
        table.on('page', function() {
                initializeSortable();
        });
    });

    function updateMenuItemOrder(order) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $.ajax({
            url: '{{ route("menu-items.update-order") }}',
            method: 'POST',
            data: {
                order: order,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    if (typeof toastr !== 'undefined') {
                        toastr.success(response.message);
                    }
                    $('#menu-items-table').DataTable().ajax.reload(null, false);

                } else {
                    if (typeof toastr !== 'undefined') {
                        toastr.error(response.message || '{{ __("dash.error_updating_order") }}');
                    }
                    $('#menu-items-table').DataTable().ajax.reload(null, false);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr.responseText);
                if (typeof toastr !== 'undefined') {
                    toastr.error('{{ __("dash.error_updating_order") }}');
                }
                $('#menu-items-table').DataTable().ajax.reload(null, false);
            }
        });
    }
});</script>
    @endpush

</x-dashboard.layout>
