<!-- /.main-footer -->
<footer class="main-footer">
    <div class="main-footer__top">
        <div class="container">
            <div class="main-footer__top__inner wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="200ms">
                <div class="footer-widget__logo logo-retina">
                    <a href="{{url('/')}}"><img src="{{ asset('uploads/settings/' . $settings->white_logo) }}" width="258" height="auto" alt="{{ $settings->alt_white_logo }}"></a>
                </div><!-- /.footer-widget__logo -->

                <ul class="list-unstyled footer-widget__list">
                    <li>
                        <div class="footer-widget__list__icon"><i class="icon-email"></i></div><!-- /.footer-widget__list__icon -->
                        <div class="footer-widget__list__content">
                            <span class="footer-widget__list__subtitle">@lang('home.send email')</span>
                            <a href="mailto:{{$settings->contact_email}}">{{$settings->contact_email}}</a>
                        </div><!-- /.footer-widget__list__content -->
                    </li>
                    <li>
                        <div class="footer-widget__list__icon"><i class="icon-telephone"></i></div><!-- /.footer-widget__list__icon -->
                        <div class="footer-widget__list__content">
                            <span class="footer-widget__list__subtitle">@lang('home.call agent')</span>
                            <a href="tel:{{$settings->phone1}}">{{$settings->phone1}}</a>
                        </div><!-- /.footer-widget__list__content -->
                    </li>
                    <li>
                        <div class="footer-widget__list__icon"><i class="icon-clock-1"></i></div><!-- /.footer-widget__list__icon -->
                        <div class="footer-widget__list__content">
                            <span class="footer-widget__list__subtitle">@lang('home.opening time')</span>
                            <p>Hours: Mon-Fri: 8am – 7pm</p>
                        </div><!-- /.footer-widget__list__content -->
                    </li>
                </ul><!-- /.list-unstyled -->
            </div><!-- /.main-footer__top__inner -->
        </div><!-- /.container -->
    </div><!-- /.main-footer__top -->
    <div class="main-footer__middle">
        <div class="container">
            <div class="row gutter-y-40">
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="00ms">
                    <div class="footer-widget footer-widget--about">
                        <p class="footer-widget__about-text">{!! $settings->site_desc !!}</p><!-- /.footer-widget__about-text -->
                        <div class="footer-widget__social">
                            @if($settings->facebook)<a href="{{$settings->facebook}}"> <i class="icon-facebook" aria-hidden="true"></i> <span class="sr-only">@lang('home.facebook')</span></a>@endif
                            @if($settings->twitter)<a href="{{$settings->twitter}}"><i class="icon-twitter" aria-hidden="true"></i> <span class="sr-only">@lang('home.twitter')</span></a>@endif
                            @if($settings->linkedin)<a href="{{$settings->linkedin}}"> <i class="icon-linkedin" aria-hidden="true"></i> <span class="sr-only">@lang('home.linkedin')</span></a>@endif
                            @if($settings->youtube)<a href="{{$settings->youtube}}"> <i class="icon-youtube" aria-hidden="true"></i> <span class="sr-only">@lang('home.youtube')</span></a>@endif
                        </div><!-- /.footer-widget__social -->
                    </div><!-- /.footer-widget -->
                </div><!-- /.col-lg-4 -->

                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="200ms">
                    <div class="footer-widget footer-widget--links">
                        <h2 class="footer-widget__title">@lang('quick links')</h2><!-- /.footer-widget__title -->
                        <ul class="list-unstyled footer-widget__links">
                            <li><a href="{{route('website.home')}}">@lang('home.home')</a></li>
                            <li><a href="{{route('website.about_us')}}">@lang('home.about_us')</a></li>
                            <li><a href="{{route('website.contact_us')}}">@lang('home.contct_us')</a></li>
                            <li><a href="{{route('website.blogs')}}">@lang('home.news')</a></li>
                        </ul><!-- /.list-unstyled footer-widget__links -->
                    </div><!-- /.footer-widget -->
                </div><!-- /.col-lg-4 -->

                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="400ms">
                    <div class="footer-widget footer-widget--post">
                        <h2 class="footer-widget__title">@lang('Destinations')</h2><!-- /.footer-widget__title -->
                        <ul class="list-unstyled footer-widget__links">
                            @foreach($headerDestinations as $headerDestination)
                                <li><a href="{{ LaravelLocalization::localizeUrl('destinations/' . $headerDestination->slug) }}">{{$headerDestination->name}}</a></li>
                            @endforeach
                        </ul><!-- /.list-unstyled footer-widget__links -->
                    </div><!-- /.footer-widget -->
                </div><!-- /.col-lg-6 -->

                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="400ms">
                    <div class="footer-widget footer-widget--post">
                        <h2 class="footer-widget__title">@lang('services')</h2><!-- /.footer-widget__title -->
                        <ul class="list-unstyled footer-widget__links">
                            @foreach($header_services as $header_service)
                                <li><a href="{{ LaravelLocalization::localizeUrl('services/' . $header_service->slug) }}">{{$header_service->name}}</a></li>
                            @endforeach
                        </ul><!-- /.list-unstyled footer-widget__links -->
                    </div><!-- /.footer-widget -->
                </div><!-- /.col-lg-6 -->

            </div><!-- /.row -->
        </div><!-- /.container -->
        <div class="main-footer__element-one">
            <img src="{{ WebsiteHelper::getAsset('images/shapes/footer-shape-1-1.png') }}" alt="shape">
        </div><!-- /.main-footer__element-one -->
        <div class="main-footer__element-two">
            <img src="{{ WebsiteHelper::getAsset('images/shapes/footer-shape-1-2.png') }}" alt="shape">
        </div><!-- /.main-footer__element-one -->
    </div><!-- /.main-footer__middle -->
    <div class="main-footer__bottom">
        <div class="container">
            <div class="main-footer__bottom__inner">
                <p class="main-footer__copyright">Copyrights &copy; <span class="dynamic-year">  </span> Hana Japan Traval. All Rights Reserved. - Developed By <a href="javascript::void"> Devora</a>
                </p>
                <a href="#" data-target="html" class="scroll-to-target scroll-to-top">
                    <span class="scroll-to-top__wrapper">
                        <i class="fas fa-arrow-up"></i>
                    </span>
                </a>
            </div><!-- /.main-footer__inner -->
        </div><!-- /.container -->
    </div><!-- /.main-footer__bottom -->
</footer>
