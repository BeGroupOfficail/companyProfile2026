<!DOCTYPE html>
<html class="no-js" lang="{{ $lang == 'en' ? 'en' : 'ar' }}" dir="{{ $lang == 'en' ? 'ltr' : 'rtl' }}">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @yield('title')

        <!-- favicons Icons -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('uploads/settings/' . $settings->fav_icon) }}"/>
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('uploads/settings/' . $settings->fav_icon) }}"/>
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('uploads/settings/' . $settings->fav_icon) }}"/>
        <meta name="description" content="vrf main website , we are take the lead" />

        @include('website.layouts.css')
    </head>

<body class="custom-cursor">
    <div class="custom-cursor__cursor"></div>
    <div class="custom-cursor__cursor-two"></div>

    <div class="preloader">
        <div class="preloader__image"></div>
    </div>
    <!-- /.preloader -->

    <div class="page-wrapper">
        @include('website.layouts.header')

        @yield('content')

        @include('website.layouts.footer')
    </div>
    <!-- /.page-wrapper -->

    @include('website.layouts.mobile_nav')

    <a href="javascript:void(0)" data-target="html" class="scroll-to-target scroll-to-top">
        <span class="scroll-to-top__wrapper"><span class="scroll-to-top__inner"></span></span>
        <span class="scroll-to-top__text"> @lang('home.Go Back Top')</span>
    </a>
    <ul id="wrapper" class="" style="transform: translate(15%, 100%)">
        <li class="Icon call">
            <!--<span class="tooltip">Call</span>-->
            <a href="tel:{{$settings->phone1}}"><span><img src="{{ WebsiteHelper::getAsset('images/icon/cell-phone.png') }}" alt="phone icon" /></span></a>
        </li>
        <li class="Icon whatsapp">
            <!--<span class="tooltip">whatsapp</span>-->
            <a href="{$settings->whatsapp_address}}" target="_blank"><span><i class="fab fa-whatsapp"></i></span></a>
        </li>
    </ul>

    @include('website.layouts.js')
    </body>
</html>
