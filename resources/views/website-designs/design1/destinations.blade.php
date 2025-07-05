@extends('designs::layout.main')

@section('content')

<!-- /.Popular Destination -->
<section class="destination-filter section-space" id="destination">
    <div class="container">
        <div class="destination-filter__top">
            <div class="sec-title text-center">
                <h6 class="sec-title__tagline bw-split-in-right">@lang('home.Popular Destination')</h6><!-- /.sec-title__tagline -->
                <h3 class="sec-title__title bw-split-in-left">@lang('home.Popular Destination')</h3><!-- /.sec-title__title -->
            </div><!-- /.sec-title -->
        </div><!-- /.destination-filter__top -->
        <div class="tabs-box">

            <div class="tabs-content">
                <div class="item tab active-tab">
                    <div class="row gutter-y-20 gutter-x-20">
                        @foreach($destinations as $destination)
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                                <div class="destination-card-one wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='100ms'>
                                    <div class="destination-card-one__thumb">
                                        <img src="{{WebsiteHelper::getImage('destinations',$destination->image) }}" alt="{{$destination->alt_image}}">
                                        <a href="{{route('website.destination',$destination->slug)}}" class="destination-card-one__overly"></a>
                                    </div><!-- /.destination-card-one__thumb -->
                                    <div class="destination-card-one__content">
                                        <h3 class="destination-card-one__title"><a href="{{route('website.destination',$destination->slug)}}">{{$destination->name}}</a></h3><!-- /.destination-card-one__title -->
                                    </div><!-- /.destination-one__content -->
                                </div><!-- /.destination-one -->
                            </div>
                        @endforeach
                    </div><!-- /.row -->
                </div>

            </div><!-- /.tabs-content -->
        </div><!-- /.tabs-box -->
    </div><!-- /.container -->
    <div class="destination-filter__element">
        <img src="{{ WebsiteHelper::getAsset('images/shapes/plan.png') }}" alt="shape">
    </div><!-- /.destination-filter__element -->
    <div class="destination-filter__element-two">
        <img src="{{ WebsiteHelper::getAsset('images/shapes/monjil.png') }}"  alt="shape">
    </div><!-- /.destination-filter__element -->
</section>

@endsection
