@extends('website.layouts.main')
@section('title')
    <title>{{$settings->site_name}} | @lang('home.projects')</title>
@endsection

@section('content')
    @include('website.partials.pagesSections.breadcrumb', [
        'title' => __('home.projects'),
        'items' => [
            ['label' => __('home.projects')]
        ]
    ])

    <!--Project Two Start -->
    <section class="project-two project-three">
        <div class="container">
            <div class="project-two__menu-box">
                <ul class="project-filter clearfix post-filter has-dynamic-filters-counter list-unstyled">
                    <li data-filter=".filter-item" class="active">
                        <span class="filter-text">@lang('home.View All')</span>
                    </li>
                    @foreach($services as $service)
                        <li data-filter=".{{$service->slug}}">
                            <span class="filter-text">{{$service->name}}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="row filter-layout masonary-layout">

                @foreach($services as $service)
                    @foreach($service->albums as $album)
                        @php
                            $images = $album->images; // Get all images
                            $firstImage = $images->first(); // Get first image
                            $remainingImages = $images->skip(1);
                        @endphp
                        <div class="col-xl-4 col-lg-4 col-md-6 filter-item {{$service->slug}}">
                            <div class="project-three__single">
                                <div class="project-three__img-box">
                                    <div class="project-three__img">
                                        <img src="{{WebsiteHelper::getImage('album_images',$firstImage->image) }}" />
                                        <div class="project-three__content">
                                            <div class="project-three__arrow">
                                                <a href="{{WebsiteHelper::getImage('album_images',$firstImage->image) }}" data-fancybox="Project-1"class="img-popup">
                                                    <img src="{{WebsiteHelper::getImage('album_images',$firstImage->image) }}" width="200" height="150" alt="Sample image #1"/>
                                                    <span class="icon-up-arrow"></span>
                                                </a>
                                                <div style="display: none">
                                                    @foreach($remainingImages as $image)
                                                        <a href="{{WebsiteHelper::getImage('album_images',$image->image) }}" data-fancybox="Project-1">
                                                            <img src="{{WebsiteHelper::getImage('album_images',$image->image) }}" width="200" height="150" alt="Sample image #2"/>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <h3 class="project-three__title">
                                                <a href="javascript:void(0)">{{$album->title}}</a>
                                            </h3>
                                            <p class="project-three__sub-title">{{$album->text}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </section>
    <!--Project Two End -->


@endsection
