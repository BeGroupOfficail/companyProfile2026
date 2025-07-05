<x-dashboard.layout :title="__('dash.categories')">

    <!--begin::Card-->
    <div class="card">

        <x-dashboard.partials.card_header :title="'categories'" :routeName="'categories'" :modelName="'categories'"/>

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

        <script type="module">
            $(document).ready(function() {
                var table = window.LaravelDataTables['categories-table'];

                table.on('init.dt', function() {
                    $('#categories-table thead').append('<tr class="filters"></tr>');

                    $('#categories-table thead tr:eq(0) th').each(function(i) {
                        if (i === 2 || i === 3 || i === 4 || i === 7) {
                            var select = $('<select class="form-select mb-2" data-control="select2" data-placeholder="Select an option"> <option value="">' + '@lang("dash.all")' + '</option></select>')
                                .appendTo($('<th>').appendTo('#categories-table thead tr.filters'))
                                .on('change', function() {
                                    var val = $(this).val();
                                    if (val) {
                                        // بحث نص عادي (غير regex) وغير حساس لحالة الأحرف
                                        table.column(i).search(val, false, false).draw();
                                    } else {
                                        table.column(i).search('').draw();
                                    }
                                });

                            select.select2({
                                placeholder: '@lang("dash.all")',
                                width: '100%',
                                allowClear: true
                            });

                            if (i === 7) {
                                select.empty().append(`
                                    <option value="">@lang("dash.all")</option>
                                    <option value="published">@lang("dash.published")</option>
                                    <option value="inactive">@lang("dash.inactive")</option>
                                `);
                            } else {
                                table.column(i).data().unique().sort().each(function(d) {
                                    if (d) select.append('<option value="' + d + '">' + d + '</option>');
                                });
                            }
                        } else {
                            $('<th>').appendTo('#categories-table thead tr.filters');
                        }
                    });
                });
            });
        </script>
    @endpush

</x-dashboard.layout>
