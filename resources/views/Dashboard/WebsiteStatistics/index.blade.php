<x-dashboard.layout :title="__('dash.WebsiteStatistics')">

    <!--begin::Card-->
    <div class="card">

        <x-dashboard.partials.card_header :title="'WebsiteStatistics'" :routeName="'website-statistics'" :modelName="'website_statistics'"/>

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
    @endpush

</x-dashboard.layout>
