<x-dashboard.layout :title="__('dash.testimonials')">

    <!--begin::Card-->
    <div class="card">

        <x-dashboard.partials.card_header :title="'testimonials'" :routeName="'testimonials'" :modelName="'testimonials'"/>

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
