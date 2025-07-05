@if ($blogs->count() > 0)

    <!-- /.blogs -->
    <section class="blog-five section-space-top" id="blog">
        <div class="container">
            <div class="sec-title text-center">
                <h6 class="sec-title__tagline bw-split-in-right">@lang('home.Blog & News')</h6><!-- /.sec-title__tagline -->
                <h3 class="sec-title__title bw-split-in-left">@lang('home.Explore Blogs And News')</span></h3><!-- /.sec-title__title -->
            </div><!-- /.sec-title -->
            <div class="row gutter-y-30">
                @foreach ($blogs as $blog)
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <div class="blog-card-two blog-card-two--two wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='100ms'>
                            <div class="blog-card-two__image">
                                <img src="{{WebsiteHelper::getImage('blogs',$blog->image) }}" alt="{{$blog->alt_image}}">
                                <a href="{{ LaravelLocalization::localizeUrl('blogs/' . $blog->slug) }}" class="blog-card-two__image__link"><span class="sr-only"></span></a>
                            </div><!-- /.blog-card-two__image -->
                            <div class="blog-card-two__content">
                                <div class="blog-card-two__top">
                                    <div class="blog-card-two__date">
                                        {{ $blog->created_at->diffForHumans() }}
                                    </div><!-- /.blog-card-two__date -->
                                    <ul class="list-unstyled blog-card-two__meta">
                                        <li>
                                            <a href="{{ LaravelLocalization::localizeUrl('blogs/' . $blog->slug) }}"> <span class="blog-card-two__meta__icon"> <i class="icon-price-tag"></i> </span>{{ $blog->category?->name }}</a>
                                        </li>
                                    </ul><!-- /.list-unstyled blog-card-two__meta -->
                                </div><!-- /.blog-card-two__top -->
                                <h3 class="blog-card-two__title"><a href="{{ LaravelLocalization::localizeUrl('blogs/' . $blog->slug) }}">{{ $blog->name }}</a></h3><!-- /.blog-card-two__title -->
                                <a href="{{ LaravelLocalization::localizeUrl('blogs/' . $blog->slug) }}" class="blog-card-two__content__btn">@lang('home.more_details') <i class="icon-arrow-right"></i></a>
                            </div><!-- /.blog-card-two__content -->
                        </div><!-- /.blog-card-two -->
                    </div>
                @endforeach
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section>
@endif
