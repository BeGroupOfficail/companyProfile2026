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
                                <div class="project-three__img relative">
                                    
                                    {{-- First image --}}
                                    <img src="{{ WebsiteHelper::getImage('album_images', $firstImage->image) }}" alt="{{ $album->title }}" class="w-full rounded-lg object-cover" />
                        
                                    <div class="project-three__content absolute inset-0 flex flex-col justify-end p-4 bg-gradient-to-t from-black/40 to-transparent">
                                        <div class="project-three__arrow">
                                            {{-- First image link for Fancybox --}}
                                            <a href="{{ WebsiteHelper::getImage('album_images', $firstImage->image) }}" 
                                               data-fancybox="Project-{{ $album->id }}" 
                                               class="img-popup relative inline-block">
                        <span class="icon-up-arrow absolute top-2 right-2 text-white text-xl"></span>
                                            </a>
                        
                                            {{-- Hidden images for the same gallery --}}
                                            <div class="d-none">
                                                @foreach($remainingImages as $image)
                                                    <a href="{{ WebsiteHelper::getImage('album_images', $image->image) }}" data-fancybox="Project-{{ $album->id }}">
                                                        <img src="{{ WebsiteHelper::getImage('album_images', $image->image) }}" width="200" height="150" alt="{{ $album->title }}" />
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                        
                                        {{-- Album title & subtitle --}}
                                        <h3 class="project-three__title text-white text-lg font-semibold mt-2">
                                            <a href="javascript:void(0)">{{ $album->title }}</a>
                                        </h3>
                                        <p class="project-three__sub-title text-gray-200 text-sm">{{ $album->text }}</p>
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


