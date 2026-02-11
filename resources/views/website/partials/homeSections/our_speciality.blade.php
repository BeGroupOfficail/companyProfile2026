@php
    $items = $about_values->where('type', 'our_speciality');
    $chunks = $items->chunk(ceil($items->count() / 2));
@endphp
@if(count($items ) > 0 )
    <section class="why-choose-two">
        <div class="container">
            <div class="why-choose-two__top">
                <div class="row">
                    <div class="col-xl-7 col-lg-7">
                        <div class="why-choose-two__top-left">
                            <div class="section-title text-left sec-title-animation animation-style2">
                                <h6 class="section-title__tagline">@lang('home.our speciality')</h6>
                                <h3 class="section-title__title title-animation">
                                    @lang('home.Industries We Serve')
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5">
                        <div class="why-choose-two__top-right">
                            <p class="why-choose-two__top-text">
                                @lang('home.Specialized VRF System & HVAC solutions across diverse sectors in Egypt.')
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="why-choose-two__bottom">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 wow fadeInLeft" data-wow-delay="100ms">
                        <div class="why-choose-two__bottom-list-box">
                            <ul class="why-choose-two__list list-unstyled">
                                @foreach($chunks[0] ?? [] as $about_value)
                                    <li>
                                        <div class="icon">
                                            <img src="{{WebsiteHelper::getImage('about_values',$about_value->image) }}" alt="{{ $about_value->alt_image }}" />
                                        </div>
                                        <div class="content">
                                            <h3>{{$about_value->title}}</h3>
                                            <p>{!!  $about_value->description !!} </p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="200ms">
                        <div class="why-choose-two__img">
                            <img src="{{ WebsiteHelper::getAsset('images/about/choose.png') }}" alt="our speciality image" />
                        </div>
                    </div>
                    <div
                        class="col-xl-4 col-lg-4 wow fadeInRight"
                        data-wow-delay="300ms"
                    >
                        <div class="why-choose-two__bottom-list-box">
                            <ul class="why-choose-two__list list-unstyled">
                                @foreach($chunks[1] ?? [] as $about_value)
                                    <li>
                                        <div class="icon">
                                            <img src="{{WebsiteHelper::getImage('about_values',$about_value->image) }}" alt="{{ $about_value->alt_image }}" />
                                        </div>
                                        <div class="content">
                                            <h3>{{$about_value->title}}</h3>
                                            <p>{!!  $about_value->description !!}</p>
                                        </div>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
