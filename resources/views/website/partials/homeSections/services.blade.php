@if(count($services) > 0)
    <section class="services-one">
        <div class="container">
            <div class="row">
                <div class="col-xl-4">
                    <div class="services-one__left">
                        <div class="section-title text-left sec-title-animation animation-style2">
                            <h6 class="section-title__tagline">
                                <span class="icon-broken-bone"></span>@lang('home.Latest service')
                            </h6>
                            <h3 class="section-title__title title-animation">
                                VRF / HVAC @lang('home.service')
                            </h3>
                        </div>
                        <p class="services-one__text">
                            @lang('home.trusted_by_text')
                        </p>
                        <div class="services-one__btn-box">
                            <a href="{{LaravelLocalization::localizeUrl('services') }}" class="thm-btn">@lang('home.All Services') <span class="icon-plus"></span></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="services-one__right">
                        <ul class="row list-unstyled">
                            @foreach($services as $service)
                                <li class="col-xl-6 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="100ms">
                                    <div class="scene">
                                        <div class="card">
                                            <div class="card-face card-front">
                                                <div class="services-one__img">
                                                    <img src="{{WebsiteHelper::getImage('services',$service->image) }}" alt="{{$service->alt_image}}" />
                                                </div>
                                            </div>
                                            <div class="card-face card-back">
                                                <div class="services-one__single">
                                                    <h3 class="services-one__title">
                                                        <a href="{{ LaravelLocalization::localizeUrl('service/' . $service->slug) }}">{{ $service->name }}</a>
                                                    </h3>
                                                    <p class="services-one__text">{{ $service->short_desc }}</p>
                                                    <a href="{{ LaravelLocalization::localizeUrl('services/' . $service->slug) }}" class="services-one__read-more">@lang('home.Read More')<span class="icon-plus"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
