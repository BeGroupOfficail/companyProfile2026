@if ($sliders->count() > 0)
    <!-- /.main-slider-one -->
    <section class="main-slider-one" id="home">
        <div class="main-slider-one__item carousel-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-8 col-md-10">
                        <div class="main-slider-one__content">
                            <h5 class="main-slider-one__sub-title main-three bw-split-in-top">@lang('home.Discover Your Trip')</h5><!-- slider-sub-title -->
                            <h2 class="main-slider-one__title main-three bw-split-in-down">@lang('home.Hana Japan') <br> @lang('home.Travel')</h2><!-- slider-title -->
                            <p class="main-slider-one__text main-three bw-split-in-down">@lang('home.We craft unforgettable travel experiences—tailored tours, expert guides, and seamless adventures. Explore hidden gems, luxury getaways, or budget-friendly trips. Your journey starts with us')</p><!-- /.main-slider-one__text -->
                        </div><!-- /.main-slider-one__content -->
                    </div><!-- /.col-xl-6 -->
                </div><!-- /.row -->
            </div><!-- /.container -->

            <div class="main-slider-one__destinations">
                <div class="container">
                    <div class="destinations-two__inner">
                        <div class="destinations-two__carousel gotur-owl__carousel gotur-owl__carousel--custom-nav gotur-owl__carousel--with-shadow owl-carousel owl-theme">
                            @foreach ($sliders as $slider)
                                <div class="item">
                                    <div class="destinations-card-two wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='100ms'>
                                        <div class="destinations-card-two__thumb">
                                            <img src="{{WebsiteHelper::getImage('sliders',$slider->image) }}" alt="{{ $slider->alt_image }}">
                                        </div><!-- /.destinations-card-two__thumb -->
                                    </div><!-- /.destinations-card-two -->
                                </div>
                            @endforeach
                        </div><!-- /.destinations-two__carousel -->
                    </div><!-- /.destinations-two__inner -->
                </div><!-- /.container -->
                <div class="main-slider-one__destinations__hover">
                    <img src="{{ WebsiteHelper::getAsset('images/shapes/hero-1-1-hover.png') }}" alt="destinations image">
                </div><!-- /.destinations-card-two__group-card -->
            </div><!-- /.main-slider-one__dep -->
            <div class="main-slider-one__bottom__nav">
                <button class="main-slider-one__carousel__nav--left"><span class="icon-arrow-left"></span></button>
                <button class="main-slider-one__carousel__nav--right"><span class="icon-arrow-right"></span></button>
            </div>
            <div class="main-slider-one__element">
                <img src="{{ WebsiteHelper::getAsset('images/shapes/cta-1-1-popup.png') }}" alt="element">
            </div><!-- /.main-slider-one__element -->
            <div class="main-slider-one__element-one">
                <img src="{{ WebsiteHelper::getAsset('images/shapes/hero-shapr-1-2-2.png') }}" alt="element">
            </div><!-- /.main-slider-one__element -->
            <div class="main-slider-one__element-two">
                <img src="{{ WebsiteHelper::getAsset('images/shapes/hero-shapr-1-3.png') }}" alt="element">
            </div><!-- /.main-slider-one__element -->
            <div class="main-slider-one__element-three">
                <img src="{{ WebsiteHelper::getAsset('images/shapes/hero-shapr-1-2-1.png') }}" alt="element">
            </div><!-- /.main-slider-one__element -->
            <div class="main-slider-one__element-four"></div><!-- /.main-slider-one__element -->
            <div class="main-slider-one__element-five">
                <img src="{{ WebsiteHelper::getAsset('images/shapes/hero-shapr-1-2-a.png') }}" alt="element">
            </div><!-- /.main-slider-one__element -->
        </div><!-- /.main-slider-one__item -->
    </section>
@endif
