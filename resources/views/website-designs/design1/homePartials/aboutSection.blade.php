<!-- /.about-two -->
<section class="about-two about-two--two pt-50 @if(request()->segment(2) === 'about-us') section-space @endif" id="about">

    <div class="container">
        <div class="row gutter-y-40">
            <div class="col-lg-6">
                <div class="about-two__thumb wow fadeInLeft" data-wow-duration='1500ms' data-wow-delay='300ms'>
                    <div class="about-two__thumb__item  ">
                        <img src="{{WebsiteHelper::getImage('about',$aboutUs->image) }}" alt="{{$aboutUs->alt_image}}">
                    </div><!-- /.about-two__thumb__item -->
                    <div class="about-two__thumb__item-small  ">
                        <img src="{{WebsiteHelper::getImage('about',$aboutUs->banner) }}" alt="{{$aboutUs->alt_banner}}">
                    </div><!-- /.about-two__thumb__item -->
                    <div class="about-two__thumb__funfact">
                        <div class="about-two__thumb__funfact__icon">
                            <i class="icon-icon-4"></i>
                        </div><!-- /.about-two__thumb__funfact__icon -->
                        <div class="about-two__thumb__funfact__content count-box">
                            <h2 class="about-two__thumb__funfact__count">
                                <span class="count-text" data-stop="{{$settings->n_experience_years}}" data-speed="2000"></span>
                                <span>@lang('home.Years')</span>
                            </h2><!-- /.about-two__thumb__funfact__count -->
                            <p class="about-two__thumb__funfact__text">@lang('home.Of Experience')</p><!-- /.about-two__thumb__funfact__text -->
                        </div><!-- /.about-two__thumb__funfact__content -->
                    </div><!-- /.about-two__thumb__funfact -->
                    <div class="about-two__thumb__item-element">
                        <img src="{{ WebsiteHelper::getAsset('images/shapes/corki.png')}}" alt="Hana Japan Tours image">
                    </div><!-- /.about-two__thumb__item -->
                </div><!-- /.about-two__left -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <div class="about-two__right">
                    <div class="sec-title  ">
                        <h6 class="sec-title__tagline bw-split-in-right">@lang('home.About company')</h6><!-- /.sec-title__tagline -->
                        <h3 class="sec-title__title bw-split-in-left">{{$aboutUs->title}}</h3><!-- /.sec-title__title -->
                    </div><!-- /.sec-title -->
                    <p class="about-two__top__text wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='300ms'>
                        {!! $aboutUs->description !!}
                    </p>

                    <!-- /.about-two__top__text -->
                    <div class="about-two__feature">
                        <div class="row gutter-y-20 gutter-x-20">
                            @foreach ($about_values as $key=>$about_value)
                                <div class="col-xl-6 col-lg-12 col-md-6 wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='300ms'>
                                    <div class="about-two__feature-vestion">
                                        <div class="about-two__feature_icon">
                                            <img src="{{WebsiteHelper::getImage('about_values',$about_value->image) }}" alt="{{$about_value->alt_image}}">
                                        </div><!-- /.about-two__feature_icon -->
                                        <div class="about-two__feature-content">
                                            <h5 class="about-two__feature-title">{{$about_value->title}}</h5><!-- /.about-two__feature-title -->
                                            <p class="about-two__feature-text">{!! $about_value->description !!}</p><!-- /.about-two__feature-text -->
                                        </div><!-- /.about-two__feature-content -->
                                    </div><!-- /.about-two__feature-vestion -->
                                </div>
                            @endforeach
                        </div><!-- /.row -->
                    </div>
                    <!-- /.about-two__feature -->

                </div><!-- /.about-two__right -->
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
    <div class="about-two__element-one">
        <img src="{{ WebsiteHelper::getAsset('images/shapes/about-1-1.png') }}" alt="Hana Japan Tours image">
    </div><!-- /.about-two__element-one -->
    <div class="about-two__element-two">
        <img src="{{ WebsiteHelper::getAsset('images/shapes/about-1-2.png') }}" alt="Hana Japan Tours image">
    </div><!-- /.about-two__element-one -->
</section>
