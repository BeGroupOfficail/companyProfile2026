<x-dashboard.layout :title="__('dash.edit_menu_item')">

    <!--begin::Form-->
    <form method="post" action="{{route('menu-items.update',$menuItem->id)}}" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('menu-items.index')}}" enctype="multipart/form-data">
        @csrf
        @method('patch')


        <!--begin::Aside column-->
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">

            <!--begin::Status-->
            <x-dashboard.partials.html.status_select
                :model="'album'"
                :selected="$menuItem->status" />
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
                                    @foreach(config('languages') as $lang => $languageName)
                                        <x-dashboard.partials.html.input
                                            name="name_{{ $lang }}"
                                            label="{{ __('dash.name') }} ({{ __($languageName) }})"
                                            :value="old('name_' . $lang, $menuItem->getTranslation('name', $lang) ?? '')"
                                            placeholder="{{ __('dash.Enter the name in') }} {{ __($languageName) }}" />
                                    @endforeach

                                        <x-dashboard.partials.html.objects-select
                                            name="parent_id"
                                            title="{{ __('dash.parent_menu') }}"
                                            :options="$menuItems"
                                            :isTranslatable="true"
                                            :translatableValue="'name'"
                                            :selectedValue="$menuItem->parent_id"/>

                                    <x-dashboard.partials.html.input
                                        name="order"
                                        type="number"
                                        label="{{ __('dash.order') }}"
                                        :value="old('order', $menuItem->order??'')"
                                        placeholder="{{ __('dash.order') }}" />
                                </div>


                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.objects-select
                                        :options="$menus"
                                        :name="'menu_id'"
                                        :title="__('dash.menus')"
                                        :id="'menus-select'"
                                        :isTranslatable="true"
                                        :translatableValue="'name'"
                                        :selectedValue="$menuItem->menu_id"/>

                                    <x-dashboard.partials.html.select
                                        :options="$menuTypes"
                                        :name="'types'"
                                        :title="__('dash.type')"
                                        :id="'type'"
                                        :selectedValue="$menuItem->types" />

                                    <div class="fv-row w-100 flex-md-root" id="type_values">
                                        @include('Dashboard.MenuItems.type_values')
                                    </div>
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

            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <a href="{{route('menu-items.index')}}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">{{__('dash.Cancel')}}</a>
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


    @push('scripts')
        <script>
            $('#type').on('change',function(){
                var type = $('#type option:selected').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url:"{{route('menu-type-values')}}",
                    method:'POST',
                    data:{type:type},
                    success:function(html) {
                        $('#type_values').html('');
                        $('#type_values').html(html.html);
                        $('.form-select').select2();
                    }
                });
            });
        </script>
    @endpush
</x-dashboard.layout>
