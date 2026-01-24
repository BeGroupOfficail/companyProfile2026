@php
    $new_messages = \App\Models\Dashboard\ContactUs\ContactUs::new_messages();
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
                'blog_categories.read', 'blogs.read', 'services.read', 'projects.read', 'sliders.read', 'pages.read',
                'clients.read', 'testimonials.read'])
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
                                <a class="menu-link {{ request()->segment(3) == 'edit' ? 'active' : '' }}"
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
                        <div data-kt-menu-trigger="click"
                            class="menu-item menu-accordion {{ in_array(request()->segment(3), ['albums']) ? 'hover show' : '' }}">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <a class="menu-link {{ request()->segment(3) == 'albums' ? 'active' : '' }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">@lang('dash.albums') </span>
                                    <span class="menu-arrow d-none"></span>
                                </a>
                            </span>
                            <!--end:Menu link-->

                            <!--begin:Menu sub-->
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
                                <!--end:Menu item-->
                            </div>
                            <!--end:Menu sub-->
                        </div>
                        <!--end:Menu item-->
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

            @can('videos.read')
                <!--begin:videos Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item {{ in_array(request()->segment(3), ['videos']) ? 'here show' : '' }} menu-accordion">
                    <!--begin:Menu link-->
                    <a href="{{ route('videos.index') }}" class="menu-link"><span class="menu-icon"><i
                                class="ki-outline primary-color ki-document  fs-2"></i></span>
                        <span class="menu-title">{{ __('dash.videos') }}</span>
                        <span class="menu-arrow d-none"></span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:videos item-->
            @endcan

            @can('services.read')
                <!--begin:services Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item {{ in_array(request()->segment(3), ['services']) ? 'here show' : '' }} menu-accordion">
                    <!--begin:Menu link-->
                    <a href="{{ route('services.index') }}" class="menu-link"><span class="menu-icon"><i
                                class="ki-outline primary-color ki-shop  fs-2"></i></span>
                        <span class="menu-title">{{ __('dash.services') }}</span>
                        <span class="menu-arrow d-none"></span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:services item-->
            @endcan

            @can('projects.read')
                <!--begin:projects Menu item-->
                <div data-kt-menu-trigger="click"
                     class="menu-item {{ in_array(request()->segment(3), ['projects']) ? 'here show' : '' }} menu-accordion">
                    <!--begin:Menu link-->
                    <a href="{{ route('projects.index') }}" class="menu-link"><span class="menu-icon"><i
                                class="ki-outline primary-color ki-security-check  fs-2"></i></span>
                        <span class="menu-title">{{ __('dash.projects') }}</span>
                        <span class="menu-arrow d-none"></span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:projects item-->
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

            @can('website_statistics.read')
                <!--begin:Faqs Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item {{ in_array(request()->segment(3), ['website-statistics']) ? 'here show' : '' }} menu-accordion">
                    <!--begin:Menu link-->
                    <a href="{{ route('website-statistics.index') }}" class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline primary-color ki-text-number  fs-2 me-2"></i>
                        </span>
                        <span class="menu-title">{{ __('dash.WebsiteStatistics') }}</span>
                        <span class="menu-arrow d-none"></span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Faqs item-->
            @endcan


            @can('users.read')
                <!--begin:users Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ in_array(request()->segment(3), ['users']) ? 'here show ' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link"><span class="menu-icon"><i
                                class="ki-outline primary-color ki-people fs-2"></i></span>
                        <span class="menu-title">@lang('dash.users_and_roles')</span><span class="menu-arrow d-none"></span>
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
                                @can('roles.read')
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->segment(4) == 'users' ? 'active' : '' }}"
                                        href="{{ route('users.users.index') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">@lang('dash.users')</span>
                                    </a>
                                    <!--end:Menu link-->
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
                <!--begin:settings Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ in_array(request()->segment(4), ['general-settings']) || request()->segment(4) == 'home-sections' ? 'here show ' : '' }}">
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
                            class="menu-item menu-accordion {{ request()->segment(4) == 'home-sections' ? 'hover show' : '' }}">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->segment(4) == 'home-sections' ? 'active' : '' }}"
                                href="{{ route('settings.home-sections') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">@lang('dash.home_sections')</span>
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
