@if($regions->count() > 0)
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
            <div class="destination-filter__btn tab-buttons">
                @foreach($regions as $key=>$region)
                    @if($region->destinations->count() > 0)
                        <button data-tab="#region-{{$key}}" class="tab-btn gotur-btn @if($key == 0)active-btn @endif">{{$region->name}}</button>
                    @endif
                @endforeach
            </div><!-- /.tab-buttons -->
            <div class="tabs-content">

                @foreach($regions as $key=>$region)
                    @if($region->destinations->count() > 0)
                        <div class="item tab @if($key == 0) active-tab @endif" id="region-{{$key}}">
                            <div class="row gutter-y-20 gutter-x-20">
                                @foreach($region->destinations as $destination)
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                                        <div class="destination-card-one wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='100ms'>
                                            <div class="destination-card-one__thumb">
                                                <img src="{{WebsiteHelper::getImage('destinations',$destination->image) }}" alt="{{$destination->alt_image}}">
                                                <a href="{{route('website.destinations',$destination->slug)}}" class="destination-card-one__overly"></a>
                                            </div><!-- /.destination-card-one__thumb -->
                                            <div class="destination-card-one__content">
                                                <h3 class="destination-card-one__title"><a href="{{route('website.destination',$destination->slug)}}">{{$destination->name}}</a></h3><!-- /.destination-card-one__title -->
                                            </div><!-- /.destination-one__content -->
                                        </div><!-- /.destination-one -->
                                    </div>
                                @endforeach
                            </div><!-- /.row -->
                        </div>
                    @endif
                @endforeach
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
@endif
