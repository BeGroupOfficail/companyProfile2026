<!-- /.offer-one -->
<section class="offer-one section-space">
    <div class="container">
        <div class="sec-title text-center">
            <h6 class="sec-title__tagline bw-split-in-right">@lang('home.Special Offers')</h6><!-- /.sec-title__tagline -->
            <h3 class="sec-title__title bw-split-in-left">@lang('home.Offers To Inspire You')</h3><!-- /.sec-title__title -->
        </div><!-- /.sec-title -->
        <div class="row gutter-y-30 gutter-x-30">
            <div class="col-lg-6 wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='300ms'>
                <div class="offer-one__card">
                    <div class="offer-one__card__content">
                        <div class="sec-title ">
                            <h6 class="sec-title__tagline bw-split-in-right">@lang('home.Special Offer')</h6><!-- /.sec-title__tagline -->
                            <h3 class="sec-title__title bw-split-in-left">@lang('home.Explore All Tour Of The World With Us')</h3><!-- /.sec-title__title -->
                        </div><!-- /.sec-title -->
                        <div class="offer-one__card__btn">
                            <a href="{{route('website.contact_us')}}" class="gotur-btn">@lang('home.Book Now')<span class="icon"><i class="icon-right"></i></span></a>
                        </div><!-- /.offer-one__card__btn -->
                    </div><!-- /.offer-one__card__content -->
                    <div class="offer-one__card__left">
                        <div class="offer-one__card__thumb">
                            <img src="{{ WebsiteHelper::getAsset('images/resources/phone-1-3.png')}}" alt="shape">
                        </div><!-- /.offer-one__card__thumb -->
                    </div><!-- /.offer-one__card__left -->
                </div><!-- /.offer-one__card -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6 wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='500ms'>
                <div class="offer-one__card offer-one__card--two">
                    <div class="offer-one__card__left">
                        <div class="offer-one__card__thumb">
                            <img src="{{ WebsiteHelper::getAsset('images/resources/offer-1-2.jpg') }}" alt="shape">
                        </div><!-- /.offer-one__card__thumb -->
                    </div><!-- /.offer-one__card__left -->
                    <div class="offer-one__card__content">
                        <div class="sec-title text-end">
                            <h6 class="sec-title__tagline bw-split-in-right">@lang('home.Get 40% Offer')</h6><!-- /.sec-title__tagline -->
                            <h3 class="sec-title__title bw-split-in-left">@lang('home.Tours and Trip Packages, Globally')</h3><!-- /.sec-title__title -->
                        </div><!-- /.sec-title -->
                        <div class="offer-one__card__btn">
                            <a href="{{route('website.contact_us')}}" class="gotur-btn gotur-btn--primary">@lang('home.Book Now')<span class="icon"><i class="icon-right"></i></span></a>
                        </div><!-- /.offer-one__card__btn -->
                    </div><!-- /.offer-one__card__content -->
                </div><!-- /.offer-one__card -->
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
    <div class="offer-one__element">
        <img src="{{ WebsiteHelper::getAsset('images/resources/about-3-1.png') }}" alt="shape">
    </div><!-- /.offer-one__element -->
</section>
