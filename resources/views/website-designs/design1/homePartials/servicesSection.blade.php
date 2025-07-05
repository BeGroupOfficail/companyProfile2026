@if ($homeServices->count() > 0)
    <!-- /.services section -->
    <section class="feature-package section-space feature-package--two offer-one" id="guide">
        <div class="container">
            <div class="feature-package__top">
                <div class="sec-title text-center">
                    <h6 class="sec-title__tagline bw-split-in-right">@lang('home.Our Services')</h6><!-- /.sec-title__tagline -->
                    <h3 class="sec-title__title bw-split-in-left">@lang('home.Our') <span> @lang('home.Services')</span></h3><!-- /.sec-title__title -->
                </div><!-- /.sec-title -->
                <p class="destination-filter__top__text">@lang('home.Your dream trip, our expertise! Custom tours, travel planning, and insider tips for seamless adventures worldwide. Lets explore together')</p>
                <!-- /.destination-filter__top__text -->
            </div><!-- /.destination-filter__top -->

            <div class="row gutter-y-30 gutter-x-30 justify-content-center">
                @foreach ($homeServices as $homeService)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="destination-card-two after-color-2 wow fadeInUp animated" data-wow-duration="1500ms" data-wow-delay="300ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 300ms; animation-name: fadeInUp;">
                            <div class="destination-card-two__thumb">
                                <img src="{{WebsiteHelper::getImage('services',$homeService->image) }}" alt="{{$homeService->alt_image}}">
                                <a href="{{ LaravelLocalization::localizeUrl('services/' . $homeService->slug) }}" class="destination-card-two__overly"></a>
                            </div><!-- /.destination-card-two__thumb -->
                            <div class="destination-card-two__content">
                                <h3 class="destination-card-two__title"><a href="{{ LaravelLocalization::localizeUrl('services/' . $homeService->slug) }}">{{ $homeService->name }}</a></h3><!-- /.destination-card-two__title -->
                            </div><!-- /.destination-one__content -->
                        </div><!-- /.destination-one -->
                    </div>
                @endforeach

            </div>
        </div><!-- /.container -->
        <div class="offer-one__element">
            <img src="{{ WebsiteHelper::getAsset('images/resources/about-3-1.png') }}" alt="shape">
        </div>
    </section>
@endif
