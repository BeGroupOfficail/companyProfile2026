<div class="app-page  flex-column flex-column-fluid " id="kt_app_page">


    <div id="kt_app_header" class="app-header " data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-animation="false" data-kt-sticky-offset="{default: '0px', lg: '0px'}">

        <!--begin::Header container-->
        <div class="app-container  container-fluid d-flex align-items-stretch flex-stack" id="kt_app_header_container">
            <!--begin::Sidebar toggle-->
            <div class="d-flex align-items-center d-block  ms-n3" title="Show sidebar menu">

                <div class="btn btn-icon btn-active-color-primary w-35px h-35px me-1 d-lg-none" id="kt_app_sidebar_mobile_toggle">
                    <i class="ki-outline ki-abstract-14 fs-2"></i>
                </div>

                <!--begin::Logo image-->
                <a href="{{route('dashboard.home')}}">
                    <img alt="Logo" src="{{($settings->logo)?Path::uploadedImage('settings',$settings->logo) : Path::dashboardPath('media/logos/demo.png')}}" class="h-25px theme-light-show"/>
                    <img alt="Logo" src="{{($settings->dark_logo)?Path::uploadedImage('settings',$settings->logo) : Path::dashboardPath('media/logos/demo_dark.png')}}" class="h-25px theme-dark-show"/>
                </a>
                <!--end::Logo image-->
            </div>
            <!--end::Sidebar toggle-->

            <!--begin::Navbar-->
            <div class="app-navbar" id="kt_app_header_navbar">
                <div class="app-navbar-item d-flex align-items-stretch flex-lg-grow-1 me-1 me-lg-0">

                    <div class="app-sidebar-footer d-flex align-items-center px-8" id="kt_app_sidebar_footer">
                        <!--begin::User-->
                        <div class="">
                            <!--begin::User info-->
                            <div class="d-flex align-items-center" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                 data-kt-menu-overflow="true" data-kt-menu-placement="top-start">
                                <div class="d-flex flex-center cursor-pointer symbol symbol-circle symbol-40px">
                                    <img src="{{ auth()->user()->image ? Path::uploadedImage('users', auth()->user()->image) : (auth()->user()->gender == 'male' || auth()->user()->gender == null ? Path::dashboardPath('media/avatars/male.png') : Path::dashboardPath('media/avatars/female.png')) }}"
                                         alt="avatar image" />
                                </div>

                                <!--begin::Name-->
                                <div class="d-flex flex-column align-items-start justify-content-center ms-3 admin-name">
                                    <span class="text-gray-500  fs-8 fw-semibold">{{ __('dash.Hello') }}</span>
                                    <a href="javascript::void()"
                                       class="text-gray-800 fs-7 fw-bold text-hover-primary">{{ auth()->user()->name }}</a>
                                </div>
                                <!--end::Name-->
                            </div>
                            <!--end::User info-->

                            <!--begin::User account menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                                 data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <div class="menu-content d-flex align-items-center px-3">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-50px me-5">
                                            <img alt="Logo"
                                                 src="{{ auth()->user()->image ? Path::uploadedImage('users', auth()->user()->image) : (auth()->user()->gender == 'male' || auth()->user()->gender == null ? Path::dashboardPath('media/avatars/male.png') : Path::dashboardPath('media/avatars/female.png')) }}" />
                                        </div>
                                        <!--end::Avatar-->

                                        <!--begin::Username-->
                                        <div class="d-flex flex-column">
                                            <div class="fw-bold d-flex align-items-center fs-5">
                                                {{ auth()->user()->name }}
                                            </div>

                                            <a href="javascript::void()" class="fw-semibold text-muted text-hover-primary fs-7">
                                                {{ auth()->user()->email }}
                                            </a>
                                        </div>
                                        <!--end::Username-->
                                    </div>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu separator-->
                                <div class="separator my-2"></div>
                                <!--end::Menu separator-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                     data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                                    <a href="#" class="menu-link px-5">
                                        <span class="menu-title position-relative">
                                            {{ __('dash.Mode') }}
                                            <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                                <i class="ki-outline primary-color ki-night-day theme-light-show fs-2"></i>
                                                <i class="ki-outline primary-color ki-moon theme-dark-show fs-2"></i>
                                            </span>
                                        </span>
                                    </a>

                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                                         data-kt-menu="true" data-kt-element="theme-mode-menu">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3 my-0">
                                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                                <span class="menu-icon" data-kt-element="icon">
                                                    <i class="ki-outline primary-color ki-night-day fs-2"></i>
                                                </span>
                                                <span class="menu-title">
                                                    {{ __('dash.Light') }}
                                                </span>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3 my-0">
                                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                                <span class="menu-icon" data-kt-element="icon">
                                                    <i class="ki-outline primary-color ki-moon fs-2"></i> </span>
                                                <span class="menu-title">
                                                    {{ __('dash.Dark') }}
                                                </span>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->

                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                     data-kt-menu-placement="right-end" data-kt-menu-offset="-15px, 0">
                                    <a href="#" class="menu-link px-5">
                                        <span class="menu-title position-relative">
                                            {{ __('dash.language') }}

                                            <span
                                                class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">
                                                {{ LaravelLocalization::getCurrentLocaleName() }}
                                                @if (LaravelLocalization::getCurrentLocale() == 'en')
                                                    <img class="w-15px h-15px rounded-1 ms-2"
                                                         src="{{ Path::dashboardPath('media/flags/united-states.svg') }}"
                                                         alt="united-states flag" />
                                                @elseif(LaravelLocalization::getCurrentLocale() == 'ar')
                                                    <img class="w-15px h-15px rounded-1 ms-2"
                                                         src="{{ Path::dashboardPath('media/flags/egypt.svg') }}"
                                                         alt="saudi-arabia flag" />
                                                @endif
                                            </span>
                                        </span>
                                    </a>

                                    <!--begin::Menu sub-->
                                    <div class="menu-sub menu-sub-dropdown w-175px py-4">

                                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                                   class="menu-link d-flex px-5 @if ($localeCode == LaravelLocalization::getCurrentLocale()) active @endif">
                                                    <span class="symbol symbol-20px me-4">
                                                        @if ($localeCode == 'en')
                                                            <img class="rounded-1"
                                                                 src="{{ Path::dashboardPath('media/flags/united-states.svg') }}"
                                                                 alt="united-states flag" />
                                                        @elseif($localeCode == 'ar')
                                                            <img class="rounded-1"
                                                                 src="{{ Path::dashboardPath('media/flags/egypt.svg') }}"
                                                                 alt="saudi-arabia flag" />
                                                        @endif
                                                    </span>
                                                    {{ $properties['native'] }}
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                        @endforeach
                                    </div>
                                    <!--end::Menu sub-->
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-5 my-1">
                                    <a href="{{ route('users.users.edit', auth()->id()) }}" class="menu-link px-5">
                                        {{ __('dash.Account Settings') }}
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-5">
                                    <a href="" class="menu-link px-5" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        {{ __('dash.Sign Out') }}

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </a>

                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::User account menu-->
                        </div>
                        <!--end::User-->
                    </div>

                </div>
            </div>
        </div>
        <!--end::Navbar-->
    </div>
</div>
