@if(count($recentProjectAlbums) > 0)
    <section class="project-three">
        <div class="container">
            <div class="section-title text-center sec-title-animation animation-style1">
                <h6 class="section-title__tagline">@lang('home.Our Projects')</h6>
                <h3 class="section-title__title title-animation">
                    @lang('home.Our Recent Projects Albums')
                </h3>
            </div>

            <div class="row filter-layout masonary-layout">
                @foreach($recentProjectAlbums as $album)
                    @php
                        $images = $album->images; // Get all images
                        $firstImage = $images->first(); // Get first image
                        $remainingImages = $images->skip(1);
                    @endphp

                    <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="100ms">
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
    </section>
@endif


