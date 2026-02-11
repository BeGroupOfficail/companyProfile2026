@extends('website.layouts.main')
@section('title')
    <title>{{$settings->site_name}} | {{$blog->name}}</title>
@endsection

@section('content')
    @include('website.partials.pagesSections.breadcrumb', [
        'title' => $blog->name,
        'items' => [
            ['label' => __('home.blogs'), 'url' => route('website.blogs')],
            ['label' => $blog->name,],
        ]
    ])

    <section class="service-details">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="service-details__left">
                        <div class="service-details__img">
                            <img src="{{WebsiteHelper::getImage('blogs',$blog->image) }}" alt="{{$blog->alt_image}}" />
                        </div>
                        <div class="service-details__content">
                            <h3 class="service-details__title-1">{{$blog->name}} </h3>

                            {!! $blog->long_desc !!}

                        </div>
                    </div>
                </div>

                @if(count($relatedBlogs) > 0)
                    <div class="col-xl-4 col-lg-5">
                        <div class="service-details__right">
                            <div class="service-details__blogs-box">
                                <h3 class="service-details__service-title">@lang('home.other_blogs')</h3>
                                <ul class="service-details__service-list list-unstyled">
                                    @foreach($relatedBlogs as $relatedBlog)
                                        <li @if($relatedBlog->slug == $blog->slug) class="active" @endif>
                                            <a href="{{ LaravelLocalization::localizeUrl('blogs/' . $relatedBlog->slug) }}"><span class="icon-left-arrows"></span>{{ $relatedBlog->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!--blogs Page End-->
@endsection
