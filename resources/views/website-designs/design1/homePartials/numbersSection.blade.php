<!-- /. numbers -->
<section class="cta-five">
    <div class="cta-five__inner">
        <div class="cta-five__bg wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="300ms" style="background-image: url({{ WebsiteHelper::getAsset('images/backgrounds/cta-1-1.jpg')}});"></div><!-- /.cta-five__bg -->
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-6">
                    <div class="cta-five__funfact wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="400ms">
                        <ul class="cta-five__funfact__list list-unstyled">
                            <li class="cta-five__funfact__item">
                                <div class="cta-five__funfact__icon">
                                    <i class="icon-travel-and-tourism"></i>
                                </div><!-- /.cta-five__funfact__icon -->
                                <div class="cta-five__funfact__content count-box">
                                    <h3 class="cta-five__funfact__count">
                                        <span class="count-text" data-stop="{{$settings->n_tours}}" data-speed="1500"></span>
                                        <span>k+</span>
                                    </h3><!-- /.cta-five__funfact__count -->
                                    <p class="cta-five__funfact__text">@lang('home.Tours success')</p><!-- /.cta-five__funfact__text -->
                                </div><!-- /.cta-five__funfact__content -->
                            </li><!-- /.cta-five__funfact__item -->

                            <li class="cta-five__funfact__item">
                                <div class="cta-five__funfact__icon">
                                    <i class="icon-tourist"></i>
                                </div><!-- /.cta-five__funfact__icon -->
                                <div class="cta-five__funfact__content count-box">
                                    <h3 class="cta-five__funfact__count">
                                        <span class="count-text" data-stop="{{$settings->n_travelers}}" data-speed="1500"></span>
                                        <span>+</span>
                                    </h3><!-- /.cta-five__funfact__count -->
                                    <p class="cta-five__funfact__text">@lang('home.Happy Traveler')</p><!-- /.cta-five__funfact__text -->
                                </div><!-- /.cta-five__funfact__content -->
                            </li><!-- /.cta-five__funfact__item -->

                            <li class="cta-five__funfact__item">
                                <div class="cta-five__funfact__icon">
                                    <i class="icon-trophy"></i>
                                </div><!-- /.cta-five__funfact__icon -->
                                <div class="cta-five__funfact__content count-box">
                                    <h3 class="cta-five__funfact__count">
                                        <span class="count-text" data-stop="{{$settings->n_awrds}}" data-speed="1500"></span>
                                        <span>+</span>
                                    </h3><!-- /.cta-five__funfact__count -->
                                    <p class="cta-five__funfact__text">@lang('home.Awards Winning')</p><!-- /.cta-five__funfact__text -->
                                </div><!-- /.cta-five__funfact__content -->
                            </li><!-- /.cta-five__funfact__item -->

                            <li class="cta-five__funfact__item">
                                <div class="cta-five__funfact__icon">
                                    <i class="icon-quality"></i>
                                </div><!-- /.cta-five__funfact__icon -->
                                <div class="cta-five__funfact__content count-box">
                                    <h3 class="cta-five__funfact__count">
                                        <span class="count-text" data-stop="{{$settings->n_experience_years}}" data-speed="1500"></span>
                                        <span>+</span>
                                    </h3><!-- /.cta-five__funfact__count -->
                                    <p class="cta-five__funfact__text">@lang('home.Our Experience')</p><!-- /.cta-five__funfact__text -->
                                </div><!-- /.cta-five__funfact__content -->
                            </li><!-- /.cta-five__funfact__item -->

                        </ul><!-- /.cta-five__funfact__list -->
                    </div><!-- /.cta-five__thumb -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="cta-five__shape wow fadeInRight" data-wow-duration="1500ms" data-wow-delay="400ms">
                        <img src="{{ WebsiteHelper::getAsset('images/shapes/cta-1-1.png') }}" alt="shape">
                    </div><!-- /.cta-five__content -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.cta-five__inner -->
</section>
