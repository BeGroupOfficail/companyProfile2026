<!--Site Footer Three Start-->
<footer class="site-footer-three">
    <div class="site-footer-three__shape-1">
        <img src="{{ WebsiteHelper::getAsset('images/shapes/site-footer-three-shape-1.png')}}" alt="footer shape"/>
    </div>
    <div class="site-footer-three__top">
        <div class="container">
            <div class="site-footer-three__top-inner">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                        <div class="footer-widget-three__services">
                            <h4 class="footer-widget-three__title">@lang('home.services')</h4>
                            <ul class="footer-widget-three__services-link-list list-unstyled">
                                @foreach ($menu_services as $menu_service)
                                    <li>
                                        <a href="{{ LaravelLocalization::localizeUrl('service/' . $menu_service->slug) }}">{{ $menu_service->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="300ms">
                        <div class="footer-widget-three__newsletter-box footer-logo">
                            <a href="{{ LaravelLocalization::localizeUrl('/') }}">
                                <img src="{{ asset('uploads/settings/' . $settings->logo) }}" alt="website logo"/>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                        <div class="footer-widget-three__contact-info">
                            <h4 class="footer-widget-three__title">@lang('home.Get In Touch')</h4>
                            <ul class="footer-widget-three__contact-list list-unstyled">
                                <li>
                                    <div class="footer-widget-three__contact-icon">
                                        <span class="icon-envolope"></span>
                                    </div>
                                    <div class="footer-widget-three__contact-content">
                                        <span>@lang('home.Email')</span>
                                        <p class="footer-widget-three__contact-text">
                                            <a href="mailto:{{$settings->contact_email}}">{{$settings->contact_email}}</a>
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <div class="footer-widget-three__contact-icon">
                                        <span class="icon-call"></span>
                                    </div>
                                    <div class="footer-widget-three__contact-content">
                                        <span>@lang('home.Phone')</span>
                                        <p class="footer-widget-three__contact-text">
                                            <a href="tel:{{$settings->phone1}}">{{$settings->phone1}}</a>
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <div class="footer-widget-three__contact-icon">
                                        <span class="icon-pin"></span>
                                    </div>
                                    <div class="footer-widget-three__contact-content">
                                        <span>@lang('home.Location')</span>
                                        <p class="footer-widget-three__contact-text">
                                            {{ app()->getLocale() == 'en' ? $settings->address_en_1 : $settings->address1 }}
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="site-footer-three__bottom">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="site-footer-three__bottom-inner">
                        <div class="site-footer-three__copyright">
                            <p class="site-footer-three__copyright-text">© <a href="javascript:void(0)">VRF Egypt</a> 2026 | All Rights Reserved</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--Site Footer Three End-->
