<x-dashboard.layout :title="__('dash.users')">

    <!--begin::Card-->
    <div class="card">

        <x-dashboard.partials.card_header :title="'users'" :routeName="'users.users'" :modelName="'users'" :hasStatus="'no'" />

        <!--begin::Card body-->
        <div class="card-body py-4">

            <!--begin::Table-->
            <div class="dt-container dt-bootstrap5 dt-empty-footer">
                <div class="mb-4">
                    <button class="btn btn-light-primary btn-sm" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#filtersOffcanvas">
                        <i class="ki-outline ki-filter fs-3"></i>
                        {{ __('dash.filters') }}
                    </button>

                    <div class="offcanvas offcanvas-end m-5" tabindex="-1" id="filtersOffcanvas">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title">{{ __('dash.filters') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div class="row g-4" id="table-filters"></div>
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-light btn-sm" id="reset-filters">
                                    <i class="ki-outline ki-arrows-circle fs-3"></i>
                                    {{ __('dash.reset_filters') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

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
            function getColumnIndexByName(table, columnName) {
                return table.column(`${columnName}:name`).index();
            }
            $(document).ready(function() {
                var table = window.LaravelDataTables['users-table'];

                let filtersInit = false;

                // Define filterable columns
                const filterConfig = {
                    company: {
                        type: 'input'
                    },
                    status: {
                        type: 'static',
                        options: [
                            'active',
                            'inactive',
                            'blocked'
                        ]
                    },
                    job_role: {
                        type: 'static',
                         options: @json(array_values($job_roles))
                    }
                };
                let translations = {
                    company: "{{ __('dash.company') }}",
                    status: "{{ __('dash.status') }}",
                    job_role: "{{ __('dash.job_role') }}",
                };
                const statusOptions = [
                    { value: 'active', text: '{{ __("dash.active") }}' },
                    { value: 'inactive', text: '{{ __("dash.user_inactive") }}' },
                    { value: 'blocked', text: '{{ __("dash.blocked") }}' }
                ];

                table.on('init.dt', function() {
                    // Build filters
                    Object.entries(filterConfig).forEach(([key, config]) => {

                        const columnIndex = getColumnIndexByName(table, key);
                        let $filter;
                        if (config.type === 'input') {
                            // DEFAULT input
                           $filter = $(`
                                <div class="col-12">
                                    <label class="form-label fw-bold">${translations[key] ?? key}</label>
                                    <input type="text" class="form-control filter-input" data-column="${columnIndex}" placeholder="{{ __('dash.all') }}" />
                                </div>
                            `);
                            $filter.find('input').on('keyup change', function() {
                                table.column(columnIndex).search($(this).val()).draw();
                            });
                        }else{
                               $filter = $(`
                            <div class="col-12">
                                <label class="form-label fw-bold">${translations[key] ?? key}</label>
                                <select class="form-select filter-select" data-column="${columnIndex}">
                                    <option value="">{{ __('dash.all') }}</option>
                                </select>
                            </div>
                        `);

                            const select = $filter.find('select');
                            // Static options
                            if (config.type === 'static') {
                                if(key=="status"){
                                    config.options.forEach(opt => {
                                        const matched = statusOptions.find(s => s.value === opt);
                                        select.append(
                                            `<option value="${opt}">${matched ? matched.text : opt}</option>`
                                            );
                                    });
                                    
                                }else{
                                    
                                    config.options.forEach(opt => {
                                        select.append(
                                            `<option value="${opt}">${translations[opt] ?? opt}</option>`
                                            );
                                    });
                                }
                            } else {
                                table.column(columnIndex).data().unique().sort().each(function(d) {
                                    const text = $('<div>').html(d).text().trim();
                                    if (text) select.append(
                                        `<option value="${text}">${text}</option>`);
                                });
                            }

                            // Apply filter on change
                            select.on('change', function() {
                                table.column(columnIndex).search($(this).val()).draw();
                            });
                        }

                        $('#table-filters').append($filter);
                    });
                });

                // Init Select2 when offcanvas opens
                $('#filtersOffcanvas').on('shown.bs.offcanvas', function() {
                    if (!filtersInit) {
                        $('.filter-select').select2({
                            placeholder: '{{ __('dash.all') }}',
                            width: '100%',
                            allowClear: true,
                            dropdownParent: $('#filtersOffcanvas')
                        });
                        filtersInit = true;
                    }
                });

                // Reset filters
                $('#reset-filters').on('click', function() {
                    $('.filter-select').val('').trigger('change');
                    $('.filter-date').val('').trigger('change');
                    $('.filter-input').val('').trigger('change');
                    table.search('').columns().search('').draw();
                });
            });
        </script>
    @endpush


</x-dashboard.layout>
