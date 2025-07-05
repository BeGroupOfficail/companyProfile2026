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
        <div class="app-wrapper  flex-column flex-row-fluid " id="kt_app_wrapper">

            <!--begin::Sidebar-->
            <div id="kt_app_sidebar" class="app-sidebar  flex-column mt-lg-4 ps-2 pe-2 ps-lg-7 pe-lg-4 "
                 data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

                <div class="app-sidebar-logo flex-shrink-0 d-none d-lg-flex flex-center align-items-center" id="kt_app_sidebar_logo">
                    <!--begin::Logo-->
                    <a href="{{route('dashboard.home')}}">
                        <img alt="Logo" 
                        src="{{($settings->logo)?Path::uploadedImage('settings',$settings->logo) : Path::dashboardPath('media/logos/demo.png')}}" class="h-25px d-none d-sm-inline app-sidebar-logo-default theme-light-show"/>
                        <img alt="Logo" src="{{($settings->dark_logo)?Path::uploadedImage('settings',$settings->dark_logo) : Path::dashboardPath('media/logos/demo_dark.png')}}" class="h-25px theme-dark-show"/>
                    </a>
                    <!--end::Logo-->

                    <!--begin::Aside toggle-->
                    <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
                        <div class="btn btn-icon btn-active-color-primary w-30px h-30px" id="kt_aside_mobile_toggle">
                            <i class="ki-outline ki-abstract-14 fs-1"></i>
                        </div>
                    </div>
                    <!--end::Aside toggle-->
                </div>

                <x-dashboard.partials.left-sidebar/>
            </div>
            <!--end::Sidebar-->

            <!--begin::Main-->
            <div class="app-main flex-column flex-row-fluid " id="kt_app_main">

                <!--begin::Content wrapper-->
                <div class="d-flex flex-column flex-column-fluid">

                    <!--begin::Toolbar-->
                    <div id="kt_app_toolbar" class="app-toolbar  pt-2 pt-lg-10 ">

                        <!--begin::Toolbar container-->
                        <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex align-items-stretch ">
                            <!--begin::Toolbar wrapper-->
                            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                                <x-dashboard.partials.page-header :header="__('' . $title)" />
                            </div>
                            <!--end::Toolbar wrapper-->
                        </div>
                        <!--end::Toolbar container-->

                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Content-->
                    <div id="kt_app_content" class="app-content  flex-column-fluid " >
                        <!--begin::Content container-->
                        <div id="kt_app_content_container" class="app-container  container-fluid">

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
