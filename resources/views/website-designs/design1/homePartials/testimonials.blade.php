@if($testimonials->count() > 0)
<section class="about-testimonials section-space" id="testimonials">
    <div class="container">
        <div class="row align-items-center gutter-y-40">
            <div class="col-lg-4">
                <div class="about-testimonials__left wow fadeInLeft" data-wow-duration='1500ms' data-wow-delay='300ms'>
                    <div class="about-testimonials__thumb">
                        <div class="about-testimonials__thumb__item"><img src="{{ WebsiteHelper::getAsset('images/resources/testi-1-1.png')}}" alt="man"></div><!-- /.about-testimonials__item -->
                    </div><!-- /.about-testimonials__thumb -->
                </div><!-- /.about-testimonials__left -->
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-8">
                <div class="about-testimonials__right">
                    <div class="sec-title  ">
                        <h6 class="sec-title__tagline bw-split-in-right">@lang('home.testimonials')</h6><!-- /.sec-title__tagline -->
                        <h3 class="sec-title__title bw-split-in-left">@lang('home.Latest Client Feedback')</h3><!-- /.sec-title__title -->
                    </div><!-- /.sec-title -->
                    <div class="about-testimonials__carousel gotur-owl__carousel gotur-owl__carousel--basic-nav owl-carousel owl-theme wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='300ms'ß>
                        @foreach($testimonials as $testimonial)
                        <div class="about-testimonials__item">
                            <div class="about-testimonials__star">
                                @for($i =0 ; $i<=$testimonial->rate  ; $i++)
                                    <i class="icon-star"></i>
                                @endfor
                            </div><!-- /.about-testimonials__star -->
                            <p class="about-testimonials__text">{!!  $testimonial->text !!}</p><!-- / -->
                            <div class="about-testimonials__author">
                                <div class="about-testimonials__author__thumb">
                                    <img src="{{WebsiteHelper::getImage('testimonials',$testimonial->image) }}" alt="{{$testimonial->alt_image}}">
                                </div><!-- /.about-testimonials__thum -->
                                <div class="about-testimonials__content">
                                    <h6 class="about-testimonials__title">{{$testimonial->author_name}}</h6><!-- /.about-testimonials__title -->
                                    <span>{{$testimonial->author_title}}</span>
                                </div><!-- /.about-testimonials__content -->
                            </div><!-- /.about-testimonials__author -->
                        </div>
                        @endforeach

                    </div><!-- /.about-testimonials__carousel -->
                </div><!-- /.about-testimonials__right -->
            </div><!-- /.col-lg-8 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
    <div class="about-testimonials__element-one">
        <img src="{{ WebsiteHelper::getAsset('images/shapes/testi-1-3.png') }}" alt="shape">
    </div><!-- /.about-testimonials__element-one -->
    <div class="about-testimonials__element-two">
        <img src="{{ WebsiteHelper::getAsset('images/resources/testi-1-2.png') }}" alt="shape">
    </div><!-- /.about-testimonials__element-one -->
</section>
@endif
