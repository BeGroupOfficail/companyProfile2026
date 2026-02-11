@if(count($clients->where('types', 'clients') ) > 0)
    <section class="brand-two">
        <div class="container">
            <div class="section-title text-center sec-title-animation animation-style1">
                <h6 class="section-title__tagline">@lang('home.Clients')</h6>
                <h3 class="section-title__title title-animation">
                    @lang('home.Our valued Clients')
                </h3>
            </div>
            <div class="brand-two__inner">
                <div class="brand-two__carousel owl-theme owl-carousel">
                   @foreach($clients->where('types', 'clients') as $client)
                        <div class="item">
                            <div class="brand-two__single">
                                <div class="brand-two__img">
                                <img src="{{WebsiteHelper::getImage('clients',$client->image) }}" alt="{{ $client->alt_image }}" />
                                </div>
                            </div>
                        </div>
                   @endforeach
                </div>
            </div>
        </div>
    </section>
@endif


