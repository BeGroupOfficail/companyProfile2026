@php
    use App\Models\Dashboard\Seo\Seo;
    $new_messages = App\Models\Dashboard\ContactUs::new_messages();
@endphp

<!--begin::sidebar menu-->
<div class="app-sidebar-menu flex-column-fluid">
    <!--begin::Menu wrapper-->
    <div id="kt_app_sidebar_menu_wrapper" class="hover-scroll-overlay-y my-5" data-kt-scroll="true"
        data-kt-scroll-activate="true" data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
        data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px">

        <!--begin::Menu-->
        <div class="menu menu-column menu-rounded menu-sub-indention fw-bold px-6" id="#kt_app_sidebar_menu"
            data-kt-menu="true" data-kt-menu-expand="false">

            <!--begin:home page Menu item-->
            <div data-kt-menu-trigger="click" class="menu-item  menu-accordion">
                <!--begin:Menu link-->
                <a href="{{ url('/') }}" class="menu-link" target="_blank"><span class="menu-icon"><i
                            class="ki-outline primary-color ki-icon fs-2"></i></span>
                    <span class="menu-title">{{ __('dash.website') }}</span>
                    <span class="menu-arrow d-none"></span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:home page Menu item-->

            <!--begin:dashboard Menu item-->
            <div data-kt-menu-trigger="click"
                class="menu-item {{ in_array(request()->segment(3), ['']) ? 'here show' : '' }} menu-accordion">
                <!--begin:Menu link-->
                <a href="{{ route('dashboard.home') }}" class="menu-link"><span class="menu-icon"><i
                            class="ki-outline primary-color ki-graph-up fs-2"></i></span>
                    <span class="menu-title">{{ __('dash.dashboard') }}</span>
                    <span class="menu-arrow d-none"></span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:dashboard Menu item-->

            @can('contact_us.read')
                <!--begin:contactUs Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item {{ in_array(request()->segment(3), ['contact-us']) ? 'here show' : '' }} menu-accordion">
                    <!--begin:Menu link-->
                    <a href="{{ route('contact-us.index') }}" class="menu-link"><span class="menu-icon">
                            <i class="ki-outline primary-color ki-messages fs-2"></i></span>
                        <span class="menu-title">{{ __('dash.contactUs') }}</span>

                        @if ($new_messages > 0)
                            <span class="badge badge-light-success fs-base">
                                {{ $new_messages }}
                            </span>
                        @endif
                        <span class="menu-arrow d-none"></span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:contactUs Menu item-->
            @endcan

            @canany(['menus.read', 'about_us.read', 'about_values.read', 'albums.read', 'blogs.read',
                'blog_categories.read', 'blogs.read', 'services.read', 'sliders.read', 'pages.read', 'clients.read',
                'testimonials.read', 'faqs.read'])
                <div class="m-3">
                    <hr class="low-opacity">
                    <div class="t-l-opacity">@lang('dash.website content')</div>
                </div>
            @endcanany

            @can('menus.read')
                <!--begin:Menus Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item {{ in_array(request()->segment(3), ['menus', 'menu-items']) ? 'here show ' : '' }} menu-accordion">

                    <!--begin:Menu link-->
                    <span class="menu-link"><span class="menu-icon"><i
                                class="ki-outline primary-color ki-burger-menu fs-2"></i></span>
                        <span class="menu-title">{{ __('dash.menus') }}</span>
                        <span class="menu-arrow d-none"></span>
                    </span>
                    <!--end:Menu link-->

                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->segment(3) == 'menus' ? 'active' : '' }}"
                                href="{{ route('menus.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">{{ __('dash.menus') }}</span>
                            </a>
                            <!--end:Menu link-->
                        </div>

                    </div>
                    <!--end:Menu sub-->

                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->segment(3) == 'menu-items' ? 'active' : '' }}"
                                href="{{ route('menu-items.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">{{ __('dash.menu_items') }}</span>
                            </a>
                            <!--end:Menu link-->
                        </div>

                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
            @endcan

            @can('about_us.read')
                <!--begin:About About item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item {{ in_array(request()->segment(3), ['edit', 'about-values']) ? 'here show ' : '' }} menu-accordion">

                    <!--begin:Menu link-->
                    <span class="menu-link"><span class="menu-icon"><i
                                class="ki-outline primary-color ki-star fs-2"></i></span>
                        <span class="menu-title">{{ __('dash.about_site') }}</span>
                        <span class="menu-arrow d-none"></span>
                    </span>
                    <!--end:Menu link-->

                    @can('about_us.read')
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">

                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->segment(3) == 'menus' ? 'active' : '' }}"
                                    href="{{ route('about.edit') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('dash.about_site') }}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        </div>
                        <!--end:Menu sub-->
                    @endcan

                    @can('about_values.read')
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">

                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->segment(3) == 'about-values' ? 'active' : '' }}"
                                    href="{{ route('about-values.index') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('dash.about_values') }}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>

                        </div>
                        <!--end:Menu sub-->
                    @endcan
                </div>
                <!--end:About item-->
            @endcan

            @can('albums.read')
                <!--begin:Albums Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ in_array(request()->segment(3), ['albums']) ? 'here show ' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link"><span class="menu-icon"><i
                                class="ki-outline primary-color ki-folder fs-2"></i></span>
                        <span class="menu-title">@lang('dash.albums')</span><span class="menu-arrow d-none"></span>
                    </span>
                    <!--end:Menu link-->

                    <!--begin: Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->segment(3) == 'albums' && request('type') == 'images' ? 'active' : '' }}"
                                        href="{{ route('albums.index', ['type' => 'images']) }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">@lang('dash.album_images')</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->

                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->segment(3) == 'albums' && request('type') == 'videos' ? 'active' : '' }}"
                                        href="{{ route('albums.index', ['type' => 'videos']) }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">@lang('dash.album_videos')</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                    </div>
                    <!--end: Menu sub-->
                </div>
                <!--end:Album Menu item-->
            @endcan

            @can('sliders.read')
                <!--begin:sliders Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item {{ in_array(request()->segment(3), ['sliders']) ? 'here show' : '' }} menu-accordion">
                    <!--begin:Menu link-->
                    <a href="{{ route('sliders.index') }}" class="menu-link"><span class="menu-icon"><i
                                class="ki-outline primary-color ki-graph-3  fs-2"></i></span>
                        <span class="menu-title">{{ __('dash.sliders') }}</span>
                        <span class="menu-arrow d-none"></span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:sliders item-->
            @endcan

            @can('pages.read')
                <!--begin:pages Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item {{ in_array(request()->segment(3), ['pages']) ? 'here show' : '' }} menu-accordion">
                    <!--begin:Menu link-->
                    <a href="{{ route('pages.index') }}" class="menu-link"><span class="menu-icon"><i
                                class="ki-outline primary-color ki-document  fs-2"></i></span>
                        <span class="menu-title">{{ __('dash.pages') }}</span>
                        <span class="menu-arrow d-none"></span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:pages item-->
            @endcan

            @can('services.read')
                <!--begin:services Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item {{ in_array(request()->segment(3), ['services']) ? 'here show' : '' }} menu-accordion">
                    <!--begin:Menu link-->
                    <a href="{{ route('services.index') }}" class="menu-link"><span class="menu-icon"><i
                                class="ki-outline primary-color ki-document  fs-2"></i></span>
                        <span class="menu-title">{{ __('dash.services') }}</span>
                        <span class="menu-arrow d-none"></span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:services item-->
            @endcan

            @can('blogs.read')
                <!--begin:blogs Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item {{ in_array(request()->segment(3), ['blogs', 'blog-categories']) ? 'here show ' : '' }} menu-accordion">

                    <!--begin:Menu link-->
                    <span class="menu-link"><span class="menu-icon"><i
                                class="ki-outline primary-color ki-feather  fs-2"></i></span>
                        <span class="menu-title">{{ __('dash.blogs') }}</span>
                        <span class="menu-arrow d-none"></span>
                    </span>
                    <!--end:Menu link-->

                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            @can('blog_categories.read')
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->segment(3) == 'blog-categories' ? 'active' : '' }}"
                                    href="{{ route('blog-categories.index') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('dash.blog_categories') }}</span>
                                </a>
                                <!--end:Menu link-->
                            @endcan

                            @can('blogs.read')
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->segment(3) == 'blogs' ? 'active' : '' }}"
                                    href="{{ route('blogs.index') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('dash.blogs') }}</span>
                                </a>
                                <!--end:Menu link-->
                            @endcan
                        </div>
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
            @endcan

            @can('testimonials.read')
                <!--begin:Testimonial Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item {{ in_array(request()->segment(3), ['testimonials']) ? 'here show' : '' }} menu-accordion">
                    <!--begin:Menu link-->
                    <a href="{{ route('testimonials.index') }}" class="menu-link"><span class="menu-icon"><i
                                class="ki-outline primary-color ki-crown-2  fs-2"></i></span>
                        <span class="menu-title">{{ __('dash.testimonials') }}</span>
                        <span class="menu-arrow d-none"></span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Testimonial item-->
            @endcan

            @can('clients.read')
                <!--begin:Clients Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item {{ in_array(request()->segment(3), ['clients']) ? 'here show' : '' }} menu-accordion">
                    <!--begin:Menu link-->
                    <a href="{{ route('clients.index') }}" class="menu-link"><span class="menu-icon"><i
                                class="ki-outline primary-color ki-bookmark-2  fs-2"></i></span>
                        <span class="menu-title">{{ __('dash.clientss') }}</span>
                        <span class="menu-arrow d-none"></span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Clients item-->
            @endcan

            @can('faqs.read')
                <!--begin:Faqs Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item {{ in_array(request()->segment(3), ['faqs']) ? 'here show' : '' }} menu-accordion">
                    <!--begin:Menu link-->
                    <a href="{{ route('faqs.index') }}" class="menu-link"><span class="menu-icon"><i
                                class="ki-outline primary-color ki-message-question fs-2"></i></span>
                        <span class="menu-title">{{ __('dash.faqs') }}</span>
                        <span class="menu-arrow d-none"></span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Faqs item-->
            @endcan

            <div class="m-3">
                <hr class="low-opacity">
                <div class="t-l-opacity">@lang('dash.destinations and tours')</div>
            </div>

            @canany(['destinations.read', 'tours.read'])
                <!--begin:coutries regions and areas Menu item-->
                <div data-kt-menu-trigger="click"
                     class="menu-item menu-accordion {{ in_array(request()->segment(3), ['destinations', 'tours']) ? 'here show ' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link"><span class="menu-icon"><i
                                class="ki-outline primary-color ki-focus fs-2"></i></span>
                            <span class="menu-title">@lang('dash.destinations') & @lang('dash.tours')</span><span
                            class="menu-arrow d-none"></span>
                        </span>
                    <!--end:Menu link-->

                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->segment(3) == 'tours' ? 'active' : '' }}"
                               href="{{ route('tours.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">@lang('dash.tours')</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->segment(3) == 'destinations' ? 'active' : '' }}"
                               href="{{ route('destinations.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">@lang('dash.destinations')</span>
                            </a>
                            <!--end:Menu link-->
                        </div>

                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end: coutries regions and areas Menu item-->
            @endcanany

            @can('seo.read')
                <div class="m-3">
                    <hr class="low-opacity">
                    <div class="t-l-opacity">@lang('dash.seo_assistant')</div>
                </div>

                <!--begin:SEO Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item {{ in_array(request()->segment(3), ['seo']) ? 'here show' : '' }} menu-accordion">
                    <!--begin:Menu link-->
                    <a href="{{ route('seo.edit', Seo::PAGETYPES['home']) }}" class="menu-link"><span
                            class="menu-icon"><i class="ki-outline primary-color ki-magnifier fs-2"></i></span>
                        <span class="menu-title">{{ __('dash.seo') }}</span>
                        <span class="menu-arrow d-none"></span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:SEO item-->
            @endcan

            @can('users.read')
                <div class="m-3">
                    <hr class="low-opacity">
                    <div class="t-l-opacity">@lang('dash.users_and_roles')</div>
                </div>

                <!--begin:users Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ in_array(request()->segment(3), ['users']) ? 'here show ' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link"><span class="menu-icon"><i
                                class="ki-outline primary-color ki-people fs-2"></i></span>
                        <span class="menu-title">@lang('dash.users')</span><span class="menu-arrow d-none"></span>
                    </span>
                    <!--end:Menu link-->

                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click"
                            class="menu-item menu-accordion {{ request()->segment(3) == 'users' ? 'hover show' : '' }}">

                            <div class="menu-item">
                                @can('permissions.read')
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->segment(4) == 'permissions' ? 'active' : '' }}"
                                        href="{{ route('users.permissions.index') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">@lang('dash.permissions')</span>
                                    </a>
                                    <!--end:Menu link-->
                                @endcan

                                @can('roles.read')
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->segment(4) == 'roles' ? 'active' : '' }}"
                                        href="{{ route('users.roles.index') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">@lang('dash.roles')</span>
                                    </a>
                                    <!--end:Menu link-->
                                @endcan

                                @can('users.read')
                                    <div data-kt-menu-trigger="click" class="menu-item here menu-accordion">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
                                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                            <span class="menu-title">@lang('dash.users')</span><span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->

                                        <!--begin:Menu sub-->
                                        <div
                                            class="menu-sub menu-sub-accordion {{ in_array(request()->segment(4), ['users']) ? 'here show ' : '' }}">
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link {{ request()->get('type') == 'admin' ? 'active' : '' }}"
                                                    href="{{ route('users.users.index', ['type' => 'admin']) }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">@lang('dash.admins')</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->

                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                @endcan
                            </div>
                            <!--end:Menu item-->

                        </div>
                        <!--end:Menu item-->
                    </div><!--end:Menu sub-->
                </div>
                <!--end:users Menu item-->
            @endcan

            @can('settings.read')
                <div class="m-3">
                    <hr class="low-opacity">
                    <div class="t-l-opacity">@lang('dash.website settings')</div>
                </div>

                @canany(['coutries.read', 'regions.read', 'areas.read'])
                    <!--begin:coutries regions and areas Menu item-->
                    <div data-kt-menu-trigger="click"
                         class="menu-item menu-accordion {{ in_array(request()->segment(4), ['countries', 'regions', 'areas']) ? 'here show ' : '' }}">
                        <!--begin:Menu link-->
                        <span class="menu-link"><span class="menu-icon"><i
                                    class="ki-outline primary-color ki-focus fs-2"></i></span>
                            <span class="menu-title">@lang('dash.countries') & @lang('dash.regions')</span><span
                                class="menu-arrow d-none"></span>
                        </span>
                        <!--end:Menu link-->

                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->segment(4) == 'countries' ? 'active' : '' }}"
                                   href="{{ route('settings.countries.index') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">@lang('dash.countries')</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->

                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->segment(4) == 'regions' ? 'active' : '' }}"
                                   href="{{ route('settings.regions.index') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">@lang('dash.regions')</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ request()->segment(4) == 'areas' ? 'active' : '' }}"
                                   href="{{ route('settings.areas.index') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">@lang('dash.areas')</span>
                                </a>
                            </div>
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end: coutries regions and areas Menu item-->
                @endcanany

                <!--begin:settings Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ in_array(request()->segment(4), ['general-settings', 'website-designs']) || request()->segment(3) == 'messages' ? 'here show ' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link"><span class="menu-icon"><i
                                class="ki-outline primary-color ki-setting-2 fs-2"></i></span>
                        <span class="menu-title">@lang('dash.settings')</span><span class="menu-arrow d-none"></span>
                    </span>
                    <!--end:Menu link-->

                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click"
                            class="menu-item menu-accordion {{ request()->segment(4) == 'general-settings' ? 'hover show' : '' }}">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->segment(4) == 'general-settings' ? 'active' : '' }}"
                                href="{{ route('settings.general-settings.edit', 1) }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">@lang('dash.general settings')</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->

                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click"
                            class="menu-item menu-accordion {{ request()->segment(4) == 'website-designs' ? 'hover show' : '' }}">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->segment(4) == 'website-designs' ? 'active' : '' }}"
                                href="{{ route('settings.website-designs') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">@lang('dash.website_designs')</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->

                </div>
                <!--end:settings Menu item-->
            @endcan
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Menu wrapper-->
</div>
<!--end::sidebar menu-->

<!--begin::Footer-->
<div class="app-sidebar-footer d-flex align-items-center px-8 pb-10" id="kt_app_sidebar_footer">
    <!--begin::User-->
    <div class="">
        <!--begin::User info-->
        <div class="d-flex align-items-center" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
            data-kt-menu-overflow="true" data-kt-menu-placement="top-start">
            <div class="d-flex flex-center cursor-pointer symbol symbol-circle symbol-40px">
                <img src="{{ Path::dashboardPath('media/avatars/user-01.jpg') }}" alt="avatar image" />
            </div>

            <!--begin::Name-->
            <div class="d-flex flex-column align-items-start justify-content-center ms-3">
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
                            src="{{ WebsiteHelper::getImage('uploads/settings/', $settings->logo) }}" />
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
                                    src="{{ Path::dashboardPath('media/flags/saudi-arabia.svg') }}"
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
                                            src="{{ Path::dashboardPath('media/flags/saudi-arabia.svg') }}"
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
                <a href="{{ route('users.users.edit', 1) }}" class="menu-link px-5">
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
<!--end::Footer-->
