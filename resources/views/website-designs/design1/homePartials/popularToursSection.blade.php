@if($tours->count() >0 )
<!-- /.populars tours -->
<section class="feature-package feature-package--two section-space" id="guide">
    <div class="container">
        <div class="feature-package__top">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="sec-title ">
                        <h6 class="sec-title__tagline bw-split-in-right">@lang('home.popular tours')</h6><!-- /.sec-title__tagline -->
                        <h3 class="sec-title__title bw-split-in-left">@lang('home.popular tours')</h3><!-- /.sec-title__title -->
                    </div><!-- /.sec-title -->
                </div><!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <div class="feature-package__bottom__nav">
                        <button class="feature-package__carousel__nav--left"><span class="icon-arrow-left"></span></button>
                        <button class="feature-package__carousel__nav--right"><span class="icon-arrow-right"></span></button>
                    </div>
                </div><!-- /.col-lg-4 -->
            </div><!-- /.row -->
        </div><!-- /.feature-package__top -->
    </div><!-- /.container -->
    <div class="container-fluid">
        <div class="feature-package__inner">
            <div class="feature-package__carousel gotur-owl__carousel gotur-owl__carousel--custom-nav gotur-owl__carousel--with-shadow owl-carousel owl-theme" >
                @foreach($tours as $tour)
                    <div class="item">
                        <div class="listing-card-four wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='100ms'>
                            <div class="listing-card-four__image">
                                <img src="{{WebsiteHelper::getImage('tours',$tour->image) }}" alt="{{$tour->alt_image}}">

                                <ul class="listing-card-four__meta list-unstyled">
                                    <li>
                                        <a href="{{route('website.tour',$tour->slug)}}"> <span class="listing-card-four__meta__icon"> <i class="icon-pin1"></i> </span>{{$tour->destination?->name}}</a>
                                    </li>
                                    <li>
                                        <a href="{{route('website.tour',$tour->slug)}}"> <span class="listing-card-four__meta__icon"> <i class="icon-calendar"></i> </span>{{$tour->number_days}} @lang('home.Days'), {{$tour->number_nights}} @lang('home.Nights')</a>
                                    </li>
                                </ul><!-- /.listing-card-four__meta -->
                                <a href="{{route('website.tour',$tour->slug)}}" class="listing-card-four__image__overly"></a>
                            </div><!-- /.listing-card-four__image -->
                            <div class="listing-card-four__content">

                                <h3 class="listing-card-four__title"><a href="{{route('website.tour',$tour->slug)}}">{{$tour->name}}</a></h3><!-- /.listing-card-four__title -->

                                <div class="listing-card-four__content__btn">
                                    <div class="listing-card-four__price">
                                        <span class="listing-card-four__price__sub">{{$tour->number_days}} @lang('home.Days') / {{$tour->number_nights}} @lang('home.Nights')</span>
                                        <span class="listing-card-four__price__number">{{$tour->person_price_per_day}}</span>
                                    </div><!-- /.listing-card-four__price -->
                                    <a href="{{route('website.tour',$tour->slug)}}" class="listing-card-four__btn gotur-btn"> @lang('home.more_details') <span class="icon"><i class="icon-right"></i> </span></a>
                                </div><!-- /.listing-card-four__content__btn -->
                            </div><!-- /.listing-card-four__content -->
                        </div><!-- /.listing-card-four -->
                    </div>
                @endforeach

            </div><!-- /.feature-package__carousel -->
        </div><!-- /.feature-package__inner -->

    </div><!-- /.container -->

    <div class="feature-package__element">
        <img src="{{ WebsiteHelper::getAsset('images/shapes/love-1-2.png') }}" alt="shape">
    </div><!-- /.feature-package__element -->
</section>
@endif

