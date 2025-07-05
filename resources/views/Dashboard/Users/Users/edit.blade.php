<x-dashboard.layout :title="__('dash.edit_user')">

    <!--begin::Form-->
    <form method="POST" action="{{route('users.users.update',$user->id)}}" class="form d-flex flex-column flex-lg-row">
        @csrf
        @method('PATCH')
        <!--begin::Aside column-->
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">

            <!--begin::image-->
            <x-dashboard.partials.html.image_input
                :title="'Upload Image'"
                :name="'image'"
                :description="'Only *.png, *.jpg, and *.jpeg image files are accepted.'"
                :changeImageText="'Change Image'"
                :cancelImageText="'Cancel Image'"
                :removeImageText="'Remove Image'"
                :acceptedText="'image files are accepted'"
                :model="$user"
                :imageModelName="'users'"
            />
            <!--end::image -->

            <!--begin::Status-->

            <x-dashboard.partials.html.status_select
                :model="'users'"
                :selected="$user->status"
                :modelObject="$user"
            />

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
                                    <x-dashboard.partials.html.input
                                        name="f_name"
                                        label="{{ __('dash.f_name') }}"
                                        :value="old('f_name', $user->f_name)"
                                        placeholder="{{ __('dash.f_name') }}" />

                                    <x-dashboard.partials.html.input
                                        name="l_name"
                                        label="{{ __('dash.l_name') }}"
                                        :value="old('l_name', $user->l_name)"
                                        placeholder="{{ __('dash.l_name') }}" />

                                    @if($user->id != 1)
                                        <x-dashboard.partials.html.objects-select
                                            :options="$job_roles"
                                            :name="'job_role'"
                                            :title="__('dash.job_role')"
                                            :id="'job-role-select'"
                                            :selectedValue="$user->job_role"/>
                                    @endif
                                </div>

                                <div class="d-flex flex-wrap gap-5">
                                    <x-dashboard.partials.html.input
                                        name="email"
                                        label="{{ __('dash.email') }}"
                                        :value="old('email', $user->email)"
                                        placeholder="{{ __('dash.email') }}" />

                                    <x-dashboard.partials.html.input
                                        name="phone"
                                        label="{{ __('dash.phone') }}"
                                        :value="old('phone', $user->phone)"
                                        placeholder="{{ __('dash.phone') }}" />

                                    <x-dashboard.partials.html.password_input/>
                                </div>

                            </div>
                            <!--end::Card header-->

                            @if($user->id != 1)
                                <div class="card-header">

                                    <div class="card-title">
                                        <h2>{{ __('dash.assign user to roles') }} </h2>
                                    </div>
                                </div>

                                <!--begin::Card body-->
                                <div class="card-body pt-0">

                                    <div class="d-flex flex-wrap gap-5">

                                        <div class="row fv-row mb-7">
                                            <div class="col-md-6 text-md-end">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold form-label mt-3">
                                                    <span>@lang('dash.is_admin')</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip" >
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                                    </span>
                                                </label>
                                                <!--end::Label-->
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex mt-3">
                                                    <!--begin::Radio-->
                                                    <div class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="radio" value="1" name="is_admin" @checked($user->is_admin == 1) >
                                                        <label class="form-check-label" for="is_admin_yes">@lang('dash.yes')</label>
                                                    </div>

                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="radio" value="0" name="is_admin" @checked($user->is_admin == 0) >
                                                        <label class="form-check-label" for="is_admin_no">@lang('dash.no')</label>
                                                    </div>
                                                    <!--end::Radio-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-5">
                                        <x-dashboard.partials.html.select
                                            :options="$roles"
                                            :name="'roles[]'"
                                            :title="__('dash.roles')"
                                            :id="'job-title-select'"
                                            :selectedArray="$userRoles"
                                            :isMultiple="true"/>
                                    </div>

                                </div>
                                <!--end::Card header-->
                            @endif

                        </div>
                        <!--end::General options-->

                    </div>
                </div>
                <!--end::Tab pane-->

            </div>
            <!--end::Tab content-->

            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                @if($user->id != 1)
                    <a href="{{route('users.users.index')}}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">{{__('dash.Cancel')}}</a>
                @else
                    <a href="{{route('dashboard.home')}}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">{{__('dash.Cancel')}}</a>
                @endif
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

</x-dashboard.layout>

