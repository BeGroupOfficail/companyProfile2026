@extends('designs::layout.main')

@section('content')
    <section class="tour-listing-details section-space">
        <div class="tour-listing-details__destination wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='500ms'>
            <div class="container">

                <div class="tour-listing-details__destination__inner">
                    <div class="tour-listing-details__destination__left">
                        <h4 class="tour-listing-details__destination__title">{{$service->name}}</h4><!-- /.tour-listing-details__destination__title -->
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

        @if($service->album?->images->count() > 0 )
            <div class="tour-listing-details__carousel wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='500ms'>
                <div class="container">
                    <div class="destination-carousel">
                        <div class="destination-carousel__inner gotur-owl__carousel gotur-owl__carousel--basic-nav owl-carousel owl-theme" >
                            @foreach ($service->album?->images ?? [] as $image)
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

        <div class="container">
            <div class="row gutter-y-30">
                <div class="col-lg-4">
                    <div class="tour-listing-details__sidebar">
                        <div class="tour-listing-details__sidebar__item tour-listing-details__sidebar__item-form wow fadeInUp" data-wow-delay="0.4s" data-wow-duration="1500ms">
                            <h4 class="tour-listing-details__sidebar__title">@lang('home.Book This Tour')</h4><!-- /.tour-listing-details__sidebar__title -->
                            <div class="sidebar-two__form">

                                <form action="{{ route('website.contact-us-save') }}" class="comments-form__form contact-form-validated form-one" method="POST">
                                    @csrf
                                    <div class="">
                                        <div class="form-one__control">
                                            <label class="form-label">{{ trans('dash.name') }}</label>
                                            <input class="form-control @error('name') is-invalid @enderror" name="name" id="name" type="text"
                                                   value="{{ old('name') }}" required>
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
                            {!! $service->long_desc !!}
                        </div><!-- /.tour-listing-details__content__item -->

                    </div><!-- /.tour-listing-details__content__item -->

                </div><!-- /.tour-listing-details__content -->

            </div><!-- /.col-lg-8 -->

        </div><!-- /.row justify-content-center -->
        </div><!-- /.container -->
    </section><!-- /.tour-listing-details -->
@endsection
