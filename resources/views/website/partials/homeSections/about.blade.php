@php use Illuminate\Http\Request; @endphp
<section class="about-three">
    <div class="container">
        <div class="row">
            <div class="col-xl-4">
                <div class="about-three__left wow slideInLeft" data-wow-delay="100ms" data-wow-duration="2500ms">
                    <div class="about-three__img-box">
                        <div class="about-three__img">
                            <img src="{{ WebsiteHelper::getImage('about', $aboutUs->{'image' . ($lang == 'en' ? '_en' : '')}) }}" alt="about image 1" />
                        </div>
                        <div class="about-three__img-two">
                            <img src="{{ WebsiteHelper::getImage('about', $aboutUs->{'banner' . ($lang == 'en' ? '_en' : '')}) }}" alt="about image 2" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="about-three__right">
                    <div class="section-title text-left sec-title-animation animation-style2">
                        <h6 class="section-title__tagline">@lang('home.about_us')</h6>
                        <h3 class="section-title__title title-animation">
                            {{ $aboutUs->title }}</h3>
                    </div>
                    <div class="about-three__text-box mb-4">
                        <p class="about-three__text">{!! $aboutUs->description !!}</p>
                    </div>

                    @if(Request()->segment(2) == '' && count($about_values->where('type', 'mission_and_vision'))  > 0)
                        <div class="row">
                            @foreach($about_values->where('type', 'mission_and_vision') as $about_value)
                                <div class="col-sm-12 col-md-4">
                                    <div class="about-three__text-info">
                                        <h4>{{$about_value->title}}</h4>
                                        <p class="about-three__text">{{$about_value->description}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="about-three__btn-and-call-box">
                            <div class="about-three__btn-box">
                                <a href="{{ LaravelLocalization::localizeUrl('about-us') }}" class="thm-btn">@lang('home.Read More')<span class="icon-arrow-right"></span>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if(Request()->segment(2) == 'about-us')
                <div class="row pt-4">
                    @foreach($about_values->where('type', 'mission_and_vision') as $about_value)
                        <div class="col-sm-12 col-md-4">
                            <div class="about-three__text-info">
                                <h4>{{$about_value->title}}</h4>
                                <p class="about-three__text">{{$about_value->description}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>
