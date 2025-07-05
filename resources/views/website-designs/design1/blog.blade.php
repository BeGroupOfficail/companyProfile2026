@extends('designs::layout.main')

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar breadcrumb-bar-info breadcrumb-info">
        <div class="breadcrumb-img">
            <div class="breadcrumb-left">
                <img src="{{ WebsiteHelper::getAsset('img/bg/banner-bg-03.png') }}" alt="img">
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.html"> @lang('home.home')</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('website.blogs') }}"> @lang('home.blogs')</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page"> {{ $blog->name }}</li>

                            <li>
                                <i class="feather-calendar"></i>{{ $blog->created_at->diffForHumans() }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->
    <!-- Content -->
    <div class="page-content">
        <div class="container">

            <!-- Blogs -->
            <div class="row">
                <!-- Blog Details -->
                <div class="col-lg-10 mx-auto">
                    <div class="blog-details">
                        <div class="blog-detail-img text-center">
                            <img src="{{ WebsiteHelper::getImage('blogs', $blog->image) }}" class="img-fluid" alt="img">
                        </div>
                        <h1 class="breadcrumb-title">{{ $blog->name }}</h1>
                        <div class="blog-contents">
                            <p>{!! $blog->long_desc !!}</p>
                        </div>
                        <div class="blog-pagination">
                            @if ($previousBlog)
                                <div class="col-sm-6">
                                    <div class="page-previous page-link">
                                        <a href="{{ LaravelLocalization::localizeUrl('blogs/' . $previousBlog->slug) }}">
                                            <i class="feather-chevron-left"></i>@lang('home.Previous Blog')
                                        </a>
                                        <p>{{ $previousBlog->name }}</p>
                                    </div>
                                </div>
                            @endif
                            @if ($nextBlog)
                                <div class="col-sm-6 text-sm-end">
                                    <div class="page-next page-link">
                                        <a href="{{ LaravelLocalization::localizeUrl('blogs/' . $nextBlog->slug) }}"
                                            class="justify-content-sm-end">@lang('home.Next Blog')<i
                                                class="feather-chevron-right"></i></a>
                                        <p>{{ $nextBlog->name }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            <!-- /Blog Details -->

        </div>
    </div>
    </div>
    <!-- Related Posts -->
    @if ($relatedBlogs->count() > 0)
        <div class="relate-post-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3>@lang('home.related_blogs')</h3>
                        <div class="relate-slider owl-carousel">
                            @foreach ($relatedBlogs as $relatedBlog)
                                <div class="blog-grid">
                                    <div class="blog-img">
                                        <a href="{{ LaravelLocalization::localizeUrl('blogs/' . $relatedBlog->slug) }}"><img
                                                src="{{ WebsiteHelper::getImage('blogs', $relatedBlog->image) }}"
                                                class="img-fluid" alt="img"></a>
                                    </div>
                                    <div class="blog-content">
                                        <div class="user-head">
                                            <div class="badge-text">
                                                <a href="javascript:void(0);"
                                                    class="badge bg-primary-light">{{ $relatedBlog->category?->name }}</a>
                                            </div>
                                        </div>
                                        <div class="blog-title">
                                            <h3><a
                                                    href="{{ LaravelLocalization::localizeUrl('blogs/' . $relatedBlog->slug) }}">{{ $relatedBlog->name }}</a>
                                            </h3>
                                        </div>
                                        <div class="blog-content-footer d-flex justify-content-between align-items-center">
                                            <p>
                                                <span><i
                                                        class="feather-clock"></i></span>{{ $relatedBlog->created_at->diffForHumans() }}
                                            </p>
                                        </div>

                                        @if (!empty($blog->short_desc))
                                            <div
                                                class="blog-content-footer desc d-flex justify-content-between align-items-center">
                                                <p>{{ $blog->short_desc }}</p>
                                            </div>
                                        @endif
                                        <div class="gigs-card-footer justify-content-start gap-2">
                                            <a class="btn btn-primary"
                                                href="{{ LaravelLocalization::localizeUrl('blogs/' . $relatedBlog->slug) }}">
                                                @lang('home.more_details')
                                                <i class="feather-eye pe-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- /Related Posts -->

@endsection
