<x-dashboard.layout :title="__('dash.roles')">

    <!--begin::Card-->
    <div class="card">

        <x-dashboard.partials.card_header :title="'roles'" :routeName="'users.roles'" :modelName="'roles'" :hasStatus="'no'" :hasCreate="'no'"/>

        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container  container-fluid p-5">

            <!--begin::Row-->
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
                @foreach($roles as $key=>$role)
                    <!--begin::Col-->
                    <div class="col-md-4">
                        <!--begin::Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>{{$role->name}}</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-1">
                                <!--begin::Users-->
                                <div class="fw-bold text-gray-600 mb-5">@lang('dash.Total users with this role'): {{$role->users()->count()}}</div>
                                <!--end::Users-->

                                <!--begin::Permissions-->
                                <div class="d-flex flex-column text-gray-600">


                                    @foreach($role->permissions->take(10) as $permission)
                                        <div class="d-flex align-items-center py-2">
                                            <span class="bullet bg-primary me-3"></span> {{ $permission->name }}
                                        </div>
                                    @endforeach

                                    @if($role->permissions->count() > 10)

                                        <div class='d-flex align-items-center py-2'><span class='bullet bg-primary me-3'></span> <em>@lang('dash.and more permissions')...</em></div>
                                    @endif

                                </div>
                                <!--end::Permissions-->
                            </div>
                            <!--end::Card body-->

                            <!--begin::Card footer-->
                            <div class="card-footer flex-wrap pt-0">
                                <a href="{{route('users.roles.edit',$role->id)}}" class="btn btn-light btn-active-primary">@lang('dash.edit_role')</a>
                                @if($key != 0)<a href="javascript:;" class="btn btn-light btn-active-danger btn_delete_role_card" data-id="{{$role->id}}" data-delete_route="{{ route('users.roles.destroy',$role->id) }}">@lang('dash.delete_role')</a>@endif
                            </div>
                            <!--end::Card footer-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Col-->
                @endforeach


                <!--begin::Add new card-->
                <div class="ol-md-4">
                    <!--begin::Card-->
                    <div class="card h-md-100">
                        <!--begin::Card body-->
                        <div class="card-body d-flex flex-center">
                            <!--begin::Button-->
                            <a href="{{route('users.roles.create')}}" class="btn btn-clear d-flex flex-column flex-center">
                                <!--begin::Illustration-->
                                <img src="{{\App\Helper\Path::dashboardPath('media/illustrations/sketchy-1/4.png')}}" alt="" class="mw-100 mh-150px mb-7" />
                                <!--end::Illustration-->

                                <!--begin::Label-->
                                <div class="fw-bold fs-3 text-gray-600 text-hover-primary">{{__('dash.Add New Role')}}</div>
                                <!--end::Label-->
                            </a>
                            <!--begin::Button-->
                        </div>
                        <!--begin::Card body-->
                    </div>
                    <!--begin::Card-->
                </div>
                <!--begin::Add new card-->
            </div>
            <!--end::Row-->

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Card-->


    @push('scripts')
        <script>
            // Delete for individual row action
            $(document).on('click', '.btn_delete_role_card', function() {

                var deleteRoute = $(this).data('delete_route');
                deleteRoute = formatUrl(deleteRoute);
                var card =$(this).parent().parent();

                console.log(card);
                // Show confirmation alert before deleting
                Swal.fire({
                    title: "{{__('dash.are you sure?')}}",
                    text: "{{__('dash.delete this records')}}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "{{__('dash.yes, delete it')}}!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: deleteRoute, // Delete the specific item using its ID
                            type: 'DELETE',
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "@lang('dash.deleted')",
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    // Remove the card
                                    card.remove();
                                } else {
                                    alert('@lang('dash.error_delete')');
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
        </script>
    @endpush

</x-dashboard.layout>


