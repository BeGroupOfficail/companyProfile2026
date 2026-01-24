<div class="mobile-nav__wrapper">
    <div class="mobile-nav__overlay mobile-nav__toggler"></div>
    <!-- /.mobile-nav__overlay -->
    <div class="mobile-nav__content">
        <span class="mobile-nav__close mobile-nav__toggler"><i class="fa fa-times"></i></span>

        <div class="logo-box">
            <a href="{{ LaravelLocalization::localizeUrl('/') }}" aria-label="logo image">
                <img src="{{ asset('uploads/settings/' . $settings->logo) }}" width="135"  alt="website logo"/>
            </a>
        </div>
        <!-- /.logo-box -->
        <div class="mobile-nav__container"></div>
        <!-- /.mobile-nav__container -->

        <ul class="mobile-nav__contact list-unstyled">
            <li>
                <i class="fa fa-envelope"></i>
                <a href="mailto:{{$settings->contact_email}}">{{$settings->contact_email}}</a>
            </li>
            <li>
                <i class="fas fa-phone"></i>
                <a href="tel:{{$settings->phone1}}">{{$settings->phone1}}</a>
            </li>
        </ul>
        <!-- /.mobile-nav__contact -->
        <div class="mobile-nav__top">
            <div class="mobile-nav__social">
                <a href="{{$settings->facbook_address}}" class="fab fa-facebook"></a>
                <a href="{{$settings->instagram_address}}" class="fab fa-instagram"></a>
            </div>
            <!-- /.mobile-nav__social -->
        </div>
        <!-- /.mobile-nav__top -->
    </div>
    <!-- /.mobile-nav__content -->
</div>
<!-- /.mobile-nav__wrapper -->
