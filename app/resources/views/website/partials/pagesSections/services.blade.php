@if(count($services) > 0)
    <section class="    services-one bg-white all-services pt-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="services-one__right">
                        <ul class="row list-unstyled">

                            @foreach($services as $service)
                                <li class="col-xl-4 col-lg-6 col-md-6 wow fadeInLeft animated" data-wow-delay="100ms" style="
                              visibility: visible;
                              animation-delay: 100ms;
                              animation-name: fadeInLeft;
                            ">
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
                                                        <a href="{{ LaravelLocalization::localizeUrl('services/' . $service->slug) }}">{{ $service->name }}</a>
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
