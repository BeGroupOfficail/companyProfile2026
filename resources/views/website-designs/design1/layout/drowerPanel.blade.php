<div class="header-right-sidebar">
    <div class="header-right-sidebar__overlay header-right-sidebar__toggler"></div>
    <div class="header-right-sidebar__content">
        <span class="header-right-sidebar__close header-right-sidebar__toggler"><i class="fa fa-times"></i></span>
        <div class="header-right-sidebar__logo-box">
            <a href="{{route('website.home')}}" aria-label="logo image"><img src="{{ asset('uploads/settings/' . $settings->logo) }}" alt="{{ $settings->alt_logo }}" width="270" height="auto"></a>
        </div>
        <div class="header-right-sidebar__container">
            <div class="header-right-sidebar__container__about ">
                <h3 class="header-right-sidebar__container__title">{{$settings->site_name}}</h3>
                <p class="header-right-sidebar__container__text">{!!  $settings->site_desc !!}</p>
            </div>
            <div class="header-right-sidebar__container__contact">
                <h3 class="header-right-sidebar__container__title">Contact Us</h3>
                <ul class="header-right-sidebar__container__list list-unstyled">
                    @if($settings->contact_email)
                        <li class="header-right-sidebar__container__list__item ">
                            <div class="header-right-sidebar__container__icon">
                                <i class="icon-email"></i>
                            </div>
                            <div class="header-right-sidebar__container__list__content">
                                <span class="header-right-sidebar__container__list__title">@lang('home.send email')</span>
                                <a href="mailto:{{$settings->contact_email}}">{{$settings->contact_email}}</a>
                            </div>
                        </li>
                    @endif

                    @if($settings->phone1)
                        <li class="header-right-sidebar__container__list__item" >
                            <div class="header-right-sidebar__container__icon">
                                <i class="icon-telephone"></i>
                            </div>
                            <div class="header-right-sidebar__container__list__content">
                                <span class="header-right-sidebar__container__list__title">@lang('home.call agent')</span>
                                <a href="tel:{{$settings->phone1}}">{{$settings->phone1}}</a>
                            </div>
                        </li>
                    @endif


                    <li class="header-right-sidebar__container__list__item ">
                        <div class="header-right-sidebar__container__icon">
                            <i class="icon-clock"></i>
                        </div>
                        <div class="header-right-sidebar__container__list__content">
                            <span class="header-right-sidebar__container__list__title">@lang('home.opening time')</span>
                            <p>Hours: Mon-Fri: 8am – 7pm</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div><!-- /.header-right-sidebar__content -->
</div>
