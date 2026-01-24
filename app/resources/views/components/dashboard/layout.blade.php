<!DOCTYPE html>
<html lang="{{LaravelLocalization::getCurrentLocale()}}"  dir="{{LaravelLocalization::getCurrentLocaleDirection()}}">
<!--start::Head-->
<head>
    <title>{{ $title }}</title>
    <x-dashboard.partials.meta/>
    <x-dashboard.partials.css />


    @stack('styles')
</head>
<!--end::Head-->
<!--begin::Body-->
<body  id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true"  class="app-default" >

<x-dashboard.partials.theme_mode/>

<!--begin::App-->
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <!--begin::Header-->
    <x-dashboard.partials.header />
    <!--end::Header-->

    <!--begin::Wrapper-->
    <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">

        <!--begin::Sidebar-->
        <div id="kt_app_sidebar" class="app-sidebar flex-column mt-lg-4 ps-2 pe-2 ps-lg-7 pe-lg-4"
             data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

            <!-- Close button added here -->
            <div class="sidebar-toggle-btn" id="kt_app_sidebar_toggle">
                <i class="ki-outline ki-pin fs-4 toggle-icon"></i>
            </div>

            <x-dashboard.partials.left-sidebar/>
        </div>
        <!--end::Sidebar-->

        <!--begin::Main-->
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">

            <!--begin::Content wrapper-->
            <div class="d-flex flex-column flex-column-fluid">

                <!--begin::Content-->
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <!--begin::Content container-->
                    <div id="kt_app_content_container" class="app-container container-fluid">

                        {{$slot}}

                    </div>
                    <!--end::Content container-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Content wrapper-->
            <x-dashboard.partials.footer/>
        </div>
        <!--end:::Main-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Page-->

</div>
<!--end::App-->

{{--    <x-dashboard.partials.right-sidebar/>--}}

<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="ki-outline ki-arrow-up"></i></div>
<!--end::Scrolltop-->

<x-dashboard.partials.script />

@stack('scripts')
</body>
<!--end::Body-->
</html>
