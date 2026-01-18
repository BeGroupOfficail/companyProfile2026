<x-dashboard.layout :title="__('dash.blog_categories')">

    <!--begin::Card-->
    <div class="card">

        <x-dashboard.partials.card_header :title="'blog_categories'" :routeName="'blog-categories'"
            :modelName="'blog_categories'" />

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
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

        <script type="module">
            $(document).ready(function () {
                var table = window.LaravelDataTables['blog-categories-table'];

                table.on('init.dt', function () {
                    // Initialize drag and drop sorting
                    initializeDragAndDrop();
                });

                // Function to initialize drag and drop
                function initializeDragAndDrop() {
                    $('#blog-categories-table tbody').sortable({
                        handle: '.drag-handle',
                        placeholder: 'ui-state-highlight',
                        helper: function (e, tr) {
                            var $originals = tr.children();
                            var $helper = tr.clone();
                            $helper.children().each(function (index) {
                                $(this).width($originals.eq(index).width());
                            });
                            return $helper;
                        },
                        start: function (event, ui) {
                            ui.placeholder.height(ui.item.height());
                            ui.placeholder.html('<td colspan="' + ui.item.find('td').length + '"></td>');
                        },
                        update: function (event, ui) {
                            var order = [];
                            $('#blog-categories-table tbody tr').each(function (index) {
                                var categoryId = $(this).attr('id');
                                if (categoryId) {
                                    order.push({
                                        id: categoryId,
                                        order: index + 1
                                    });
                                }
                            });

                            // Send AJAX request to update order
                            updateCategoryOrder(order);
                        }
                    });
                }

                // Function to update blog category order via AJAX
                function updateCategoryOrder(order) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: '{{ route('blog-categories.update-order') }}', // You'll need to create this route
                        method: 'POST',
                        data: {
                            order: order
                        },
                        success: function (response) {
                            if (response.success) {
                                toastr.success('{{ __('dash.order_updated_successfully') }}');
                                // Optionally refresh the table
                                table.draw(false);
                            } else {
                                toastr.error('{{ __('dash.error_updating_order') }}');
                            }
                        },
                        error: function (xhr, status, error) {
                            toastr.error('{{ __('dash.error_updating_order') }}');
                            console.error('Error:', error);
                        }
                    });
                }
            });
        </script>

    @endpush

</x-dashboard.layout>