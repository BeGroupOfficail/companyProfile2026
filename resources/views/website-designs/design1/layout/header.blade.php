<!-- /.top-one -->
<div class="top-one top-one--two">
    <div class="container-fluid">
        <div class="top-one__inner">
            <ul class="list-unstyled top-one__info">
                @if($settings->phone1)
                    <li class="top-one__info__item">
                        <i class="icon-telephone"></i>
                        <a href="tel:{{$settings->phone1}}">{{$settings->phone1}}</a>
                    </li><!-- /.top-one__info__item -->
                @endif
                @if($settings->contact_email)
                    <li class="top-one__info__item">
                        <i class="icon-email"></i>
                        <a href="mailto:{{$settings->contact_email}}">{{$settings->contact_email}}</a>
                    </li><!-- /.top-one__info__item -->
                @endif
            </ul><!-- /.list-unstyled top-one__info -->
            <div class="top-one__right">
                <div class="top-one__info__item">
                    <i class="icon-maps-and-flags"></i>
                    <a href="{{$settings->google_map}}">{{$settings->address1}}</a>
                </div><!-- /.top-one__info__item -->
                <div class="top-one__social">
                    @if($settings->facebook)<a href="{{$settings->facebook}}"> <i class="icon-facebook" aria-hidden="true"></i> <span class="sr-only">@lang('home.facebook')</span></a>@endif
                    @if($settings->twitter)<a href="{{$settings->twitter}}"><i class="icon-twitter" aria-hidden="true"></i> <span class="sr-only">@lang('home.twitter')</span></a>@endif
                    @if($settings->linkedin)<a href="{{$settings->linkedin}}"> <i class="icon-linkedin" aria-hidden="true"></i> <span class="sr-only">@lang('home.linkedin')</span></a>@endif
                    @if($settings->youtube)<a href="{{$settings->youtube}}"> <i class="icon-youtube" aria-hidden="true"></i> <span class="sr-only">@lang('home.youtube')</span></a>@endif
                </div><!-- /.top-one__social -->
            </div><!-- /.top-one__right -->
        </div><!-- /.top-one__inner -->
    </div><!-- /.container-fluid -->
</div>

<!-- /.main-header -->
<header class="main-header main-header--one sticky-header sticky-header--normal">
    <div class="container-fluid">
        <div class="main-header__inner">
            <div class="main-header__logo logo-retina">
                <a href="{{route('website.home')}}"><img src="{{ asset('uploads/settings/' . $settings->logo) }}" alt="{{ $settings->alt_logo }}" width="270" height="auto"></a>
            </div><!-- /.main-header__logo -->
            <div class="main-header__right">
                <nav class="main-header__nav main-menu">
                    <ul class="main-menu__list">

                        @foreach ($headMenu?->items ?? [] as $headItem)
                            @if ($headItem->types == 'home')
                                <li>
                                    <a class="{{ request()->segment(2) == '' ? 'active' : '' }}" href="{{ LaravelLocalization::localizeUrl('/') }}">{{ $headItem->name }}</a>
                                </li>
                            @elseif($headItem->types == 'about-us')
                                <li>
                                    <a class="{{ request()->segment(2) == 'about-us' ? 'active' : '' }}" href="{{ LaravelLocalization::localizeUrl('about-us') }}">{{ $headItem->name }}</a>
                                </li>
                            @elseif($headItem->types == 'contact-us')
                                <li>
                                    <a class="{{ request()->segment(2) == 'contact-us' ? 'active' : '' }}" href="{{ LaravelLocalization::localizeUrl('contact-us') }}">{{ $headItem->name }}</a>
                                </li>
                            @elseif($headItem->types == 'link')
                                <li>
                                    <a href="{{ $headItem->link }}" class="">{ $headItem->name }} </a>
                                </li>
                            @elseif($headItem->types == 'services')
                                <li class="dropdown">
                                    <a href="{{ LaravelLocalization::localizeUrl('services') }}">{{ $headItem->name }}</a>
                                    @if (count($header_services) > 0)
                                        <ul>
                                            @foreach ($header_services as $header_service)
                                                <li><a href="{{ LaravelLocalization::localizeUrl('services/' . $header_service->slug) }}">{{ $header_service->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @elseif($headItem->types == 'tours')
                                <li class="dropdown">
                                    <a href="{{ LaravelLocalization::localizeUrl('tours') }}">{{ $headItem->name }}</a>
                                    @if (count($headerTours) > 0)
                                        <ul>
                                            @foreach ($headerTours as $headerTour)
                                                <li><a href="{{ LaravelLocalization::localizeUrl('tours/' . $headerTour->slug) }}">{{ $headerTour->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @elseif($headItem->types == 'destinations')
                                <li class="dropdown">
                                    <a href="{{ LaravelLocalization::localizeUrl('destinations') }}">{{ $headItem->name }}</a>
                                    @if (count($headerDestinations) > 0)
                                        <ul>
                                            @foreach ($headerDestinations as $headerDestination)
                                                <li><a href="{{ LaravelLocalization::localizeUrl('destinations/' . $headerDestination->slug) }}">{{ $headerDestination->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @elseif($headItem->types == 'page')
                                <li>
                                    <a href="{{ LaravelLocalization::localizeUrl('pages/' . $headItem->page->slug) }}"
                                       class="{{ request()->segment(3) == $headItem->page->slug ? 'active' : '' }}">
                                        {{ $headItem->name }}
                                    </a>
                                </li>
                            @elseif($headItem->types == 'blog-category')
                                <li>
                                    <a href="{{ LaravelLocalization::localizeUrl('blogs/' . $headItem->blog_category->slug) }}"
                                       class="{{ request()->segment(3) == $headItem->blog_category->slug ? 'active' : '' }}">
                                        {{ $headItem->name }}
                                    </a>
                                </li>
                            @elseif($headItem->types == 'pages')
                                <li class="dropdown">
                                    <a href="javascript::void"> {{ $headItem->name }}</a>
                                    @if (count($header_pages) > 0)
                                        <ul>
                                            @foreach ($header_pages as $header_page)
                                                <li>
                                                    <a href="{{ LaravelLocalization::localizeUrl('pages/' . $header_page->slug) }}">
                                                        {{ $header_page->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @elseif($headItem->types == 'blogs')
                                <li class="dropdown">
                                    <a href="{{ LaravelLocalization::localizeUrl('blogs') }}"> {{ $headItem->name }} </a>
                                    @if (count($header_blogs) > 0)
                                        <ul>
                                            @foreach ($header_blogs as $header_blog)
                                                <li>
                                                    <a href="{{ LaravelLocalization::localizeUrl('blogs/' . $header_blog->slug) }}">
                                                        {{ $header_blog->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @elseif($headItem->types == 'blog-categories')
                                <li class="dropdown">
                                    <a href="javascript::void"> {{ $headItem->name }}</a>
                                    @if (count($header_blog_categories) > 0)
                                        <ul>
                                            @foreach ($header_blog_categories as $header_blog_category)
                                                <li>
                                                    <a href="{{ LaravelLocalization::localizeUrl('blog-categories/' . $header_blog_category->slug) }}">
                                                        {{ $header_blog_category->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>

                            @elseif($headItem->types == 'main-menu')
                                @if ($headItem->subMenus->count() > 0)
                                    <li class="dropdown">
                                        <a href="javascript::void"> {{ $headItem->name }}</a>
                                        <ul>
                                            @foreach ($headItem->subMenus as $subMenu)
                                                <li>
                                                    <a href='{{ LaravelLocalization::localizeUrl("$subMenu->types") }}'>
                                                        {{ $subMenu->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li >
                                        <a href="javascript::void"> {{ $headItem->name }} </a>
                                    </li>
                                @endif
                            @endif

                        @endforeach
                    </ul>
                </nav><!-- /.main-header__nav -->
                <div class="main-header__info">

{{--                    <a href="#" class="search-toggler main-header__info__item"> <i class="icon-search-interface-symbol" aria-hidden="true"></i> <span class="sr-only">Search</span> </a>--}}

                    @if(LaravelLocalization::getCurrentLocale() == 'en')
                        <a href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}" class="main-header__info__item"> <i class="fas fa-language"></i> @lang('home.ar') </a>
                    @else
                        <a href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}" class="main-header__info__item"> <i class="fas fa-language"></i> @lang('home.en') </a>
                    @endif
                </div>
                <div class="main-header__btn-popup main-header__element__btn">
                    <i class="icon-menu-bar"></i>
                </div><!-- /.mobile-nav__toggler -->
                <a href="{{route('website.contact_us')}}" class="gotur-btn main-header__btn">@lang('home.get in touch')  <i class="icon-paper-plane"></i></a>
                <div class="mobile-nav__btn mobile-nav__toggler">
                    <span></span>
                    <span></span>
                    <span></span>
                </div><!-- /.mobile-nav__toggler -->
            </div><!-- /.main-header__right -->
        </div><!-- /.main-header__inner -->
    </div><!-- /.container-fluid -->
</header>
