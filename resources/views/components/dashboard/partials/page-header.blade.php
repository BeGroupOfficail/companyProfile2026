<!--begin::Page title-->
<div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
    <!--begin::Title-->
    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">{{$header}}</h1>
    <!--end::Title-->

    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="{{route('dashboard.home')}}" class="text-muted text-hover-primary">{{__('dash.dashboard')}} </a>
        </li>
        <!--end::Item-->

        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->

        @yield('breadcrumbs')

        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">{{$header}} </li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
</div>
<!--end::Page title-->
