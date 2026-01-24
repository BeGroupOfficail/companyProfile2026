@if ($sliders->count() > 0)

    <section class="main-slider-two">
        <div
            class="swiper-container thm-swiper__slider"
            data-swiper-options='{"slidesPerView": 1, "loop": true,
                    "effect": "fade",
                    "pagination": {
                    "el": "#main-slider-pagination",
                    "type": "bullets",
                    "clickable": true
                    },
                    "navigation": {
                    "nextEl": "#main-slider__swiper-button-next",
                    "prevEl": "#main-slider__swiper-button-prev"
                    },
                    "autoplay": {
                        "delay": 8000
                    }
                }'
        >
            <div class="swiper-wrapper">
                @foreach ($sliders as $key=>$slider)
                    <div class="swiper-slide">
                        <div class="main-slider-two__bg" style="background-image: url({{WebsiteHelper::getImage('sliders',$slider->image) }}"></div>
                        <div class="main-slider-two__bg-overly"></div>
                        <div class="container">
                            <div class="row h-100 justify-content-center align-items-center text-center">
                                <div class="col-xl-12">
                                    <div class="main-slider-two__content">
                                        <p class="main-slider-two__sub-title mb-2">{{$slider->text}}</p>
                                        <h2 class="main-slider-two__title">{{ $slider->title }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="swiper-pagination" id="main-slider-pagination"></div>
            <!-- If we need navigation buttons -->
        </div>
    </section>

@endif
