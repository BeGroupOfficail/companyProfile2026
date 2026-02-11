@if(count($blogs) > 0 )
    <section class="blog-one">
        <div class="container">
            @if(request()->segment(2) == '')
                <div class="section-title text-center sec-title-animation animation-style1">
                    <h6 class="section-title__tagline"><span class="icon-broken-bone"></span>@lang('home.Latest Blog and news')</h6>
                </div>
            @endif
            
            <div class="row">
                @foreach($blogs as $blog)
                    <div class="col-xl-4 col-lg-4 wow fadeInLeft animated" data-wow-delay="100ms">
                        <div class="blog-one__single">
                            <div class="blog-one__img-box">
                                <div class="blog-one__img">
                                    <img src="{{ $blog->image ? WebsiteHelper::getImage('blogs', $blog->image) : WebsiteHelper::getImage('settings', $settings->logo) }}" class="img-fluid" alt="{{ $blog->alt_image }}"></a>
                                    <div class="blog-one__date-box">
                                        <div class="blog-one__date-icon">
                                            <span class="icon-calender"></span>
                                        </div>
                                        <div class="blog-one__date-text">
                                            <p>{{ $blog->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="blog-one__plus">
                                        <a href="{{ LaravelLocalization::localizeUrl('blogs/' . $blog->slug) }}"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-one__content">
                                <ul class="blog-one__meta list-unstyled">
                                    <li>
                                        <div class="icon">
                                            <span class="icon-user"></span>
                                        </div>
                                        <p>Admin</p>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <span class="icon-file"></span>
                                        </div>
                                        <p>{{ $blog->category?->name }} </p>
                                    </li>
                                </ul>
                                <h3 class="blog-one__title"><a href="{{ LaravelLocalization::localizeUrl('blogs/' . $blog->slug) }}">{{ $blog->name }}</a></h3>
                                <p>{{ $blog->short_desc }}</p>
                                <div class="blog-one__read-more">
                                    <a href="{{ LaravelLocalization::localizeUrl('blogs/' . $blog->slug) }}" class="thm-btn">@lang('home.Read More') <span class="icon-plus"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif