@extends('designs::layout.main')

@section('content')

    @if($tours->count() >0 )
        <!-- /.populars tours -->
        <section class="feature-package feature-package--two section-space" id="guide">
            <div class="container">
                <div class="feature-package__top">
                    <div class="sec-title text-center">
                        <div class="col-lg-12">
                            <div class="sec-title ">
                                <h6 class="sec-title__tagline bw-split-in-right">@lang('home.popular tours')</h6><!-- /.sec-title__tagline -->
                                <h3 class="sec-title__title bw-split-in-left">@lang('home.popular tours')</h3><!-- /.sec-title__title -->
                            </div><!-- /.sec-title -->
                        </div><!-- /.col-lg-8 -->
                    </div><!-- /.row -->
                </div><!-- /.feature-package__top -->
            </div><!-- /.container -->
            <div class="container-fluid">
                <div class="feature-package__inner">
                    <div class="row gutter-y-30" >
                        @foreach($tours as $tour)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
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

@endsection
