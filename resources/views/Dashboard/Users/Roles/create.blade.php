<x-dashboard.layout :title="__('dash.add_role')">

    <!--begin::Form-->
    <form method="post" action="{{route('users.roles.store')}}" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('users.permissions.index')}}" enctype="multipart/form-data">
        @csrf
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
                                    <x-dashboard.partials.html.input
                                        name="name"
                                        label="{{ __('dash.name') }}"
                                        :value="old('name')"
                                        placeholder="{{ __('dash.Enter permission name') }}" />
                                </div>


                                <div class="fv-row  pt-3">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-bold form-label mb-2">@lang('dash.Role Permissions')</label>
                                    <!--end::Label-->

                                    <!--begin::Table wrapper-->
                                    <div class="table-responsive">
                                        <!--begin::Table-->
                                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                                            <!--begin::Table body-->
                                            <tbody class="text-gray-600 fw-semibold">
                                            <!--begin::Table row-->
                                            <tr>
                                                <td class="text-gray-800">
                                                    @lang('dash.Administrator Access')
                                                    <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Allows a full access to the system" data-kt-initialized="1">
                                                    <i class="ki-outline ki-information fs-7"></i> </span>
                                                </td>
                                                <td>
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-9">
                                                        <input class="form-check-input" type="checkbox"  value="" id="selectAll" data-gtm-form-interact-field-id="1">
                                                        <span class="form-check-label" for="kt_roles_select_all">@lang('dash.Select all')</span>
                                                    </label>
                                                    <!--end::Checkbox-->
                                                </td>
                                            </tr>
                                            <!--end::Table row-->

                                            @foreach($permissions as $permission)
                                                <!--begin::Table row-->
                                                <tr>
                                                    <!--begin::Label-->
                                                    <td class="text-gray-800">{{$permission->name}}</td>
                                                    <!--end::Label-->

                                                    <!--begin::Options-->
                                                    <td>
                                                        <!--begin::Wrapper-->
                                                        <div class="d-flex">
                                                            <!--begin::Checkbox-->
                                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                <input class="form-check-input" type="checkbox" value="{{$permission->name.'.read'}}" name="permissions[]">
                                                                <span class="form-check-label">@lang('dash.Read')</span>
                                                            </label>
                                                            <!--end::Checkbox-->

                                                            <!--begin::Checkbox-->
                                                            <label class="form-check form-check-sm form-check-custom form-check-solid  me-5 me-lg-20">
                                                                <input class="form-check-input" type="checkbox" value="{{$permission->name.'.create'}}" name="permissions[]">
                                                                <span class="form-check-label">@lang('dash.Create')</span>
                                                            </label>
                                                            <!--end::Checkbox-->

                                                            <!--begin::Checkbox-->
                                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                <input class="form-check-input" type="checkbox" value="{{$permission->name.'.update'}}" name="permissions[]">
                                                                <span class="form-check-label">@lang('dash.update')</span>
                                                            </label>
                                                            <!--end::Checkbox-->

                                                            <!--begin::Checkbox-->
                                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                <input class="form-check-input" type="checkbox" value="{{$permission->name.'.delete'}}" name="permissions[]">
                                                                <span class="form-check-label">@lang('dash.delete')</span>
                                                            </label>
                                                            <!--end::Checkbox-->

                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </td>
                                                    <!--end::Options-->
                                                </tr>
                                                <!--end::Table row-->
                                            @endforeach

                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Table wrapper-->
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
                <a href="{{route('users.permissions.index')}}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">{{__('dash.Cancel')}}</a>
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
            $(document).ready(function() {
                // "Select All" checkbox functionality
                $('#selectAll').click(function() {
                    // Select or deselect all checkboxes based on the "select all" checkbox
                    $('.form-check-input').prop('checked', $(this).prop('checked'));
                });

            });

        </script>
    @endpush
</x-dashboard.layout>
