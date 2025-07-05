@extends('designs::layout.main')

@section('content')

    <section class="contact-top section-space">
        <div class="container">
            <div class="feature-package__top">
                <div class="sec-title text-center">
                    <h6 class="sec-title__tagline bw-split-in-right">@lang('home.Get In Touch')</h6><!-- /.sec-title__tagline -->
                    <h3 class="sec-title__title bw-split-in-left">@lang('home.Contact US')</h3><!-- /.sec-title__title -->
                </div><!-- /.sec-title -->
                <p class="destination-filter__top__text">@lang('home.Have questions or feedback? We would love to hear from you! Reach out via email, phone, or our contact form, and we will get back to you as soon as possible. Your satisfaction is our priority!')</p>
            </div>

            <div class="row gutter-y-30">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='300ms'>
                    <div class="contact-top__item">
                        <div class="contact-top__item__icon">
                            <i class="icon-pin"></i>
                        </div><!-- /.contact-top__item__icon -->
                        <h4 class="contact-top__item__title">@lang('home.Our Address')</h4>
                        @if($settings->address1)<p class="contact-top__item__text">{{ $settings->address1 }}</p>@endif
                        @if($settings->address2)<p class="contact-top__item__text">{{ $settings->address2 }}</p>@endif

                    </div><!-- /.contact-top__item -->
                </div><!-- /.col-lg-4 col-md-6 -->

                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='500ms'>
                    <div class="contact-top__item">
                        <div class="contact-top__item__icon">
                            <i class="icon-mail-3"></i>
                        </div><!-- /.contact-top__item__icon -->
                        <h4 class="contact-top__item__title"><a href="mailto:{{ $settings->address1 }}">{{ $settings->address1 }}</a></h4>
                        <p class="contact-top__item__text">@lang('home.Email us anytime for anykind ofquety')</p><!-- /.contact-top__item__text -->
                    </div><!-- /.contact-top__item -->
                </div><!-- /.col-lg-4 col-md-6 -->

                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='700ms'>
                    <div class="contact-top__item">
                        <div class="contact-top__item__icon">
                            <i class="icon-call-3"></i>
                        </div><!-- /.contact-top__item__icon -->
                        <h4 class="contact-top__item__title">Hot:<a href="tel:{{$settings->phone1}}">{{$settings->phone1}}</a></h4><!-- /.contact-top__item__title -->
                        <p class="contact-top__item__text">@lang('home.Call us any kind suppor,we will wait for it')</p><!-- /.contact-top__item__text -->
                    </div><!-- /.contact-top__item -->

                </div><!-- /.col-lg-4 col-md-6 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section>

    <section class="contact-page section-space-bottom">
        <div class="container">
            <div class="row gutter-y-30">
                <div class="col-lg-6 wow fadeInLeft" data-wow-duration='1500ms' data-wow-delay='300ms'>
                    <div class="contact-page__map">
                        <div class="google-map google-map__@@extraClassName">
                            <iframe title="template google map" src="{{$settings->google_map}}" class="map__@@extraClassName" allowfullscreen></iframe>
                        </div>
                        <!-- /.google-map -->
                    </div><!-- /.contact-page__map -->
                </div><!-- /.col-lg-5 -->
                <div class="col-lg-6 wow fadeInRight" data-wow-duration='1500ms' data-wow-delay='300ms'>
                    <div class="contact-page__contact">
                        <h2 class="contact-page__title">@lang('home.Ready to Get Started?')</h2><!-- /.contact-page__title -->
                        <p class="contact-page__text">Nullam varius, erat quis iaculis dictum, eros urna varius eros, ut blandit felis odio in turpis. Quisque rhoncus</p><!-- /.contact-page__text -->

                        <form action="{{ route('website.contact-us-save') }}" class="comments-form__form contact-form-validated form-one" method="POST">
                            @csrf
                            <div class="form-one__group">
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
                                <div class="form-one__control form-one__control--full">
                                    <button type="submit" class="gotur-btn gotur-btn--base">{{ __('home.send_message') }}<i class="icon-arrow-right"></i></button>
                                </div>
                            </div>
                        </form>


                    </div><!-- /.contact-page__contact -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </div>
    </section>
@endsection
