@extends('website.layouts.main')
@section('title')
    <title>{{$settings->site_name}} | {{$service->name}}</title>
@endsection

@section('content')
    @include('website.partials.pagesSections.breadcrumb', [
        'title' => $service->name,
        'items' => [
            ['label' => __('home.services'), 'url' => route('website.services')],
            ['label' => $service->name,],
        ]
    ])

    <section class="service-details">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="service-details__left">
                        <div class="service-details__img">
                            <img src="{{WebsiteHelper::getImage('services',$service->image) }}" alt="{{$service->alt_image}}" />
                        </div>
                        <div class="service-details__content">
                            <h3 class="service-details__title-1">{{$service->name}} </h3>

                            {!! $service->long_desc !!}

                            <h4 class="service-details__title-3 mb-3">@lang('home.service albums')</h4>

                            <div class="row filter-layout masonary-layout">
                                @foreach($service->albums as $album)
                                    @php
                                        $images = $album->images; // Get all images
                                        $firstImage = $images->first(); // Get first image
                                        $remainingImages = $images->skip(1);
                                    @endphp

                                    <div class="col-xl-6 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="100ms">
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
                            </div>
                        </div>
                    </div>
                </div>

                @if(count($relatedServices) > 0)
                    <div class="col-xl-4 col-lg-5">
                        <div class="service-details__right">
                            <div class="service-details__services-box">
                                <h3 class="service-details__service-title">@lang('home.other_services')</h3>
                                <ul class="service-details__service-list list-unstyled">
                                    @foreach($relatedServices as $relatedService)
                                        <li @if($relatedService->slug == $service->slug) class="active" @endif>
                                            <a href="{{ LaravelLocalization::localizeUrl('services/' . $relatedService->slug) }}"><span class="icon-left-arrows"></span>{{ $relatedService->name }}</a>
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
    <!--Services Page End-->
@endsection
