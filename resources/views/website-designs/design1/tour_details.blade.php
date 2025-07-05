@extends('designs::layout.main')

@section('content')
    <section class="tour-listing-details section-space">
        <div class="tour-listing-details__destination wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='500ms'>
            <div class="container">

                <div class="tour-listing-details__destination__inner">
                    <div class="tour-listing-details__destination__left">
                        <h4 class="tour-listing-details__destination__title">{{$tour->name}}</h4><!-- /.tour-listing-details__destination__title -->
                        <div class="tour-listing-details__destination__revue">
                            <div class="tour-listing-details__destination__posted">
                                <i class="icon-pin1"></i>
                                <p class="tour-listing-details__destination__posted-text">{{$tour->destination?->country?->name}} - {{$tour->destination?->region?->name}} </p>
                            </div><!-- / -->
                        </div><!-- /.tour-listing-details__destination__revue -->
                    </div><!-- /.tour-listing-details__destination__left -->
                    <div class="tour-listing-details__destination__right">
                        <a href="javascript:void(0)" class="tour-listing-details__destination__btn gotur-btn">Share <i class="icon-share"></i></a>
                        <div class="tour-listing-details__destination__social__list">
                            <a href="https://twitter.com/">
                                <i class="fab fa-twitter" aria-hidden="true"></i>
                                <span class="sr-only">Twitter</span>
                            </a>
                            <a href="https://facebook.com/">
                                <i class="fab fa-facebook" aria-hidden="true"></i>
                                <span class="sr-only">Facebook</span>
                            </a>
                            <a href="https://pinterest.com/">
                                <i class="fab fa-pinterest-p" aria-hidden="true"></i>
                                <span class="sr-only">Pinterest</span>
                            </a>
                            <a href="https://instagram.com/">
                                <i class="fab fa-instagram" aria-hidden="true"></i>
                                <span class="sr-only">Instagram</span>
                            </a>
                        </div>
                    </div><!-- /.tour-listing-details__destination__right -->
                </div><!-- /.tour-listing-details__destination__inner -->
            </div><!-- /.container -->
        </div><!-- /.tour-listing-details__destination -->

        @if($tour->album?->images->count() > 0 )
            <div class="tour-listing-details__carousel wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='500ms'>
                <div class="container">
                    <div class="destination-carousel">
                        <div class="destination-carousel__inner gotur-owl__carousel gotur-owl__carousel--basic-nav owl-carousel owl-theme" >
                            @foreach ($tour->album?->images ?? [] as $image)
                                <div class="item">
                                    <div class="destination-carousel__item">
                                        <img src="{{WebsiteHelper::getImage('album_images',$image->image) }}" alt="{{ $image->alt_image }}">
                                    </div><!-- /.destination-carousel__item -->
                                </div><!-- /.item -->
                            @endforeach
                        </div><!-- /.destination-carousel__inner -->
                    </div><!-- /.destination-carousel -->
                </div><!-- /.container -->
            </div><!-- /.tour-listing-details__carousel -->
        @endif

        <div class="tour-listing-details__info-area wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='500ms'>
            <div class="container">
                <ul class="tour-listing-details__info-area__info list-unstyled">
                    <li>
                        <div class="tour-listing-details__info-area__icon">
                            <i class="icon-location"></i>
                        </div><!-- /.tour-listing-details__info-area__icon -->
                        <div class="tour-listing-details__info-area__content">
                            <h5 class="tour-listing-details__info-area__title">@lang('home.destination')</h5><!-- /.tour-listing-details__info-area__title -->
                            <p class="tour-listing-details__info-area__text">{{$tour->destination->name}}</p><!-- /.tour-listing-details__info-area__text -->
                        </div><!-- /.tour-listing-details__info-area__content -->
                    </li>
                    <li>
                        <div class="tour-listing-details__info-area__icon">
                            <i class="icon-travel-and-tourism"></i>
                        </div><!-- /.tour-listing-details__info-area__icon -->
                        <div class="tour-listing-details__info-area__content">
                            <h5 class="tour-listing-details__info-area__title">@lang('home.tour_type')</h5><!-- /.tour-listing-details__info-area__title -->
                            <p class="tour-listing-details__info-area__text">{{$tour->tour_type}}</p><!-- /.tour-listing-details__info-area__text -->
                        </div><!-- /.tour-listing-details__info-area__content -->
                    </li>
                    <li>
                        <div class="tour-listing-details__info-area__icon">
                            <i class="icon-clock"></i>
                        </div><!-- /.tour-listing-details__info-area__icon -->
                        <div class="tour-listing-details__info-area__content">
                            <h5 class="tour-listing-details__info-area__title">@lang('home.number_days')</h5><!-- /.tour-listing-details__info-area__title -->
                            <p class="tour-listing-details__info-area__text">{{$tour->number_days}}</p><!-- /.tour-listing-details__info-area__text -->
                        </div><!-- /.tour-listing-details__info-area__content -->
                    </li>
                    <li>
                        <div class="tour-listing-details__info-area__icon">
                            <i class="icon-group"></i>
                        </div><!-- /.tour-listing-details__info-area__icon -->
                        <div class="tour-listing-details__info-area__content">
                            <h5 class="tour-listing-details__info-area__title">@lang('home.number_nights')</h5><!-- /.tour-listing-details__info-area__title -->
                            <p class="tour-listing-details__info-area__text">{{$tour->number_nights}}</p><!-- /.tour-listing-details__info-area__text -->
                        </div><!-- /.tour-listing-details__info-area__content -->
                    </li>
                    <li>
                        <a href="#" class="gotur-btn">{{$tour->person_price_per_day}} @lang('home.person_price_per_day')</a>
                    </li>
                </ul><!-- /.tour-listing-details__info-area__info -->
            </div><!-- /.container -->
        </div><!-- /.tour-listing-details__info-area -->
        <div class="container">
            <div class="row gutter-y-30">
                <div class="col-lg-4">
                    <div class="tour-listing-details__sidebar">
                        <div class="tour-listing-details__sidebar__item tour-listing-details__sidebar__item-form wow fadeInUp" data-wow-delay="0.4s" data-wow-duration="1500ms">
                            <h4 class="tour-listing-details__sidebar__title">Book This Tour</h4><!-- /.tour-listing-details__sidebar__title -->
                            <div class="sidebar-two__form">

                                <form action="{{ route('website.contact-us-save') }}" class="comments-form__form contact-form-validated form-one" method="POST">
                                    @csrf
                                    <div class="">
                                        <div class="form-one__control">
                                            <label class="form-label">{{ trans('dash.name') }}</label>
                                            <input class="form-control @error('name') is-invalid @enderror" name="name" id="name" type="text"
                                                   value="{{ old('name') }}"required>
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-one__control">
                                            <label class="form-label">{{ trans('dash.email') }}</label>
                                            <input class="form-control @error('email') is-invalid @enderror" name="email" id="email" type="email"
                                                   value="{{ old('email') }}" required>
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-one__control">
                                            <label class="form-label">{{ trans('dash.phone') }}</label>
                                            <input class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" type="text"
                                                   value="{{ old('phone') }}"  required>
                                            @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-one__control">
                                            <label class="form-label">{{ trans('dash.title') }}</label>
                                            <input class="form-control @error('title') is-invalid @enderror" name="title" id="title" type="text"
                                                   value="{{ old('title') }}" required>
                                            @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-one__control form-one__control--full">
                                            <label class="form-label">{{ trans('dash.message') }}</label>
                                            <textarea name="message" class="form-control @error('message') is-invalid @enderror" id="message" cols="30" rows="4" required>{{ old('message') }}</textarea>
                                            @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-one__control form-one__control--full mt-3">
                                            <button type="submit" class="gotur-btn gotur-btn--base">{{ __('home.send_message') }}<i class="icon-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div><!-- /.tour-listing-details__sidebar__item -->

                        <div class="tour-listing-details__sidebar__item tour-listing-details__sidebar__item-location wow fadeInUp" data-wow-delay="0.4s" data-wow-duration="1500ms">
                            <div class="tour-listing-details__sidebar__item-box">
                                <iframe title="template google map" src="{{$settings->google_map}}" class="map__@@extraClassName" allowfullscreen></iframe>
                            </div>
                        </div><!-- /.tour-listing-details__sidebar__item -->
                    </div><!-- /.tour-listing-details-details__sidebar -->
                </div>

                <div class="col-lg-8">
                    <div class="tour-listing-details__content">
                        <div class="tour-listing-details__content__item tour-listing-details__content__text wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='500ms'>
                            <h4 class="tour-listing-details__title">@lang('home.Overview')</h4><!-- /.tour-listing-details__title -->
                            {!! $tour->long_desc !!}
                        </div><!-- /.tour-listing-details__content__item -->

                            <h4 class="tour-listing-details__title">@lang('home.Tour Plan')</h4><!-- /.tour-listing-details__title -->
                            {!! $tour->tour_plan !!}
                        </div><!-- /.tour-listing-details__content__item -->

                    </div><!-- /.tour-listing-details__content -->

                </div><!-- /.col-lg-8 -->

                <div class="col-12 mt-5">
                    <div class="tour-listing-details__content__item tour-listing-details__ture-list">
                        <h4 class="tour-listing-details__title">@lang('home.Related Tour')</h4><!-- /.tour-listing-details__title -->
                        <div class="row">
                            @foreach($relatedTours as $relatedTour)
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                    <div class="listing-card-four wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='100ms'>
                                        <div class="listing-card-four__image">
                                            <img src="{{WebsiteHelper::getImage('tours',$relatedTour->image) }}" alt="{{$relatedTour->alt_image}}">

                                            <ul class="listing-card-four__meta list-unstyled">
                                                <li>
                                                    <a href="{{route('website.tour',$relatedTour->slug)}}"> <span class="listing-card-four__meta__icon"> <i class="icon-pin1"></i> </span>{{$tour->destination?->name}}</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('website.tour',$relatedTour->slug)}}"> <span class="listing-card-four__meta__icon"> <i class="icon-calendar"></i> </span>{{$tour->number_days}} @lang('home.Days'), {{$tour->number_nights}} @lang('home.Nights')</a>
                                                </li>
                                            </ul><!-- /.listing-card-four__meta -->
                                            <a href="{{route('website.tour',$relatedTour->slug)}}" class="listing-card-four__image__overly"></a>
                                        </div><!-- /.listing-card-four__image -->
                                        <div class="listing-card-four__content">

                                            <h3 class="listing-card-four__title"><a href="{{route('website.tour',$relatedTour->slug)}}">{{$relatedTour->name}}</a></h3><!-- /.listing-card-four__title -->

                                            <div class="listing-card-four__content__btn">
                                                <div class="listing-card-four__price">
                                                    <span class="listing-card-four__price__sub">{{$relatedTour->number_days}} @lang('home.Days') / {{$relatedTour->number_nights}} @lang('home.Nights')</span>
                                                    <span class="listing-card-four__price__number">{{$relatedTour->person_price_per_day}}</span>
                                                </div><!-- /.listing-card-four__price -->
                                                <a href="{{route('website.tour',$relatedTour->slug)}}" class="listing-card-four__btn gotur-btn"> @lang('home.more_details') <span class="icon"><i class="icon-right"></i> </span></a>
                                            </div><!-- /.listing-card-four__content__btn -->
                                        </div><!-- /.listing-card-four__content -->
                                    </div><!-- /.listing-card-four -->
                                </div>
                            @endforeach
                        </div><!-- /.row -->
                    </div><!-- / -->
                </div>
            </div><!-- /.row justify-content-center -->
        </div><!-- /.container -->
    </section><!-- /.tour-listing-details -->
@endsection
