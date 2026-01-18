<header class="main-header-three">
    <div class="main-header-three__wrapper">
        <div class="main-menu-three__top">
            <div class="container">
                <div class="main-menu-three__top-inner">
                    <ul class="list-unstyled main-menu-three__contact-list">
                        <li>
                            <div class="icon">
                                <i class="icon-envolope"></i>
                            </div>
                            <div class="text">
                                <p>
                                    <a href="mailto:{{$settings->contact_email}}">{{$settings->contact_email}}</a>
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <i class="icon-pin"></i>
                            </div>
                            <div class="text">
                                <p>{{ app()->getLocale() == 'en' ? $settings->address_en_1 : $settings->address1 }}</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <i class="icon-date"></i>
                            </div>
                            <div class="text">
                                <p>{{ app()->getLocale() == 'en' ? 'Sunday - Friday: 9 am - 8 pm' : 'الأحد - الخميس : ٩ صباحاً - ٨ مساءً' }}</p>
                            </div>
                        </li>
                    </ul>
                    <div class="main-menu-three__top-right">
                        <div class="main-menu-three__social">
                            <a href="{{$settings->facebook_address}}"><i class="icon-facebook"></i></a>
                            <a href="{{$settings->instagram_address}}"><i class="icon-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="main-menu main-menu-three">
            <div class="main-menu-three__wrapper">
                <div class="container">
                    <div class="main-menu-three__wrapper-inner">
                        <div class="main-menu-three__left">
                            <div class="main-menu-three__logo">
                                <a href="{{ LaravelLocalization::localizeUrl('/') }}">
                                    <img src="{{ asset('uploads/settings/' . $settings->logo) }}" alt="website logo"/>
                                </a>
                            </div>
                        </div>
                        <div class="main-menu-three__main-menu-box">
                            <a href="javascript:void(0)" class="mobile-nav__toggler"><i class="fa fa-bars"></i></a>
                            <ul class="main-menu__list">

                                @foreach ($headMenu?->published_items()->whereNull('parent_id')->get() ?? [] as $headItem)
                                    @if ($headItem->types == 'home')
                                        <li>
                                            <a href="{{ $headItem->custom_link }}" class="{{ request()->segment(2) == '' ? 'active' : '' }}">{{ $headItem->name }} </a>
                                        </li>
                                    @elseif($headItem->types == 'about-us')
                                        <li>
                                            <a href="{{ $headItem->custom_link }}" class="{{ request()->segment(2) == 'about-us' ? 'active' : '' }}">{{ $headItem->name }} </a>
                                        </li>

                                    @elseif($headItem->types == 'clients')
                                        <li>
                                            <a href="{{ $headItem->custom_link }}" class="{{ request()->segment(2) == 'clients' ? 'active' : '' }}">{{ $headItem->name }} </a>
                                        </li>

                                    @elseif($headItem->types == 'projects')
                                        <li>
                                            <a href="{{ $headItem->custom_link }}" class="{{ request()->segment(2) == 'projects' ? 'active' : '' }}">{{ $headItem->name }} </a>
                                        </li>
                                    @elseif($headItem->types == 'portfolio')
                                        <li>
                                            <a href="{{ $headItem->custom_link }}" class="{{ request()->segment(2) == 'portfolio' ? 'active' : '' }}">{{ $headItem->name }} </a>
                                        </li>
                                    @elseif($headItem->types == 'contact-us')
                                        <li>
                                            <a href="{{ $headItem->custom_link }}" class="{{ request()->segment(2) == 'contact-us' ? 'active' : '' }}">{{ $headItem->name }} </a>
                                        </li>

                                    @elseif($headItem->types == 'services')
                                        <li class="dropdown">
                                            <a href="javascript:void(0)">@lang('home.services')</a>
                                            @if (count($menu_services) > 0 || $headItem->subMenus->count() > 0)
                                                <ul>
                                                    <li>
                                                        <a href="{{ LaravelLocalization::localizeUrl('services/') }}">@lang('home.all_services')</a>
                                                    </li>
                                                    @if ($headItem->subMenus->count() > 0)
                                                        @foreach ($headItem->subMenus as $subMenu)
                                                            <li>
                                                                <a href='{{ $subMenu->custom_link }}'>{{ $subMenu->name }}</a>
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                    @foreach ($menu_services as $menu_service)
                                                        <li>
                                                            <a href="{{ LaravelLocalization::localizeUrl('services/' . $menu_service->slug) }}">{{ $menu_service->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="main-menu-three__right">
                            <div class="main-menu-three__call">
                                <div class="main-menu-three__call-icon">
                                    <img src="{{ WebsiteHelper::getAsset('images/icon/chat-icon.png')}}" alt="phone icon" />
                                </div>
                                <div class="main-menu-three__call-number">
                                    <p>@lang('home.Hotline')</p>
                                    <h5><a href="tel:{{$settings->phone1}}">{{$settings->phone1}}</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>

<!-- /.stricky-header -->
<div class="stricky-header stricked-menu main-menu main-menu-three">
    <div class="sticky-header__content"></div>
    <!-- /.sticky-header__content -->
</div>

