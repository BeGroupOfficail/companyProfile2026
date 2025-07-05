<div class="app-page  flex-column flex-column-fluid " id="kt_app_page">


    <div id="kt_app_header" class="app-header " data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-animation="false" data-kt-sticky-offset="{default: '0px', lg: '0px'}">

        <!--begin::Header container-->
        <div class="app-container  container-fluid d-flex align-items-stretch flex-stack mt-lg-8 " id="kt_app_header_container">
            <!--begin::Sidebar toggle-->
            <div class="d-flex align-items-center d-block d-lg-none ms-n3" title="Show sidebar menu">
                <div class="btn btn-icon btn-active-color-primary w-35px h-35px me-1" id="kt_app_sidebar_mobile_toggle">
                    <i class="ki-outline ki-abstract-14 fs-2"></i>
                </div>

                <!--begin::Logo image-->

                <a href="{{route('dashboard.home')}}">
                    <img alt="Logo" src="{{($settings->logo)?Path::uploadedImage('settings',$settings->logo) : Path::dashboardPath('media/logos/demo.png')}}" class="h-25px theme-light-show"/>
                    <img alt="Logo" src="{{($settings->dark_logo)?Path::uploadedImage('settings',$settings->dark_logo) : Path::dashboardPath('media/logos/demo_dark.png')}}" class="h-25px theme-dark-show"/>
                </a>
                <!--end::Logo image-->
            </div>
            <!--end::Sidebar toggle-->

            <!--begin::Navbar-->
            <div class="app-navbar flex-lg-grow-1" id="kt_app_header_navbar">
                <div class="app-navbar-item d-flex align-items-stretch flex-lg-grow-1 me-1 me-lg-0">

                </div>
            </div>
        </div>
        <!--end::Navbar-->
    </div>
</div>
