@if(count($websiteStatistics) > 0)
    <section class="counter-two">
        <div class="container">
            <div class="counter-two__inner">
                <ul class="counter-two__count-list list-unstyled">
                    @foreach ($websiteStatistics as $websiteStatistic)
                    <li>
                        <div class="icon">
                            <img src="{{WebsiteHelper::getImage('websiteStatistic',$websiteStatistic->image) }}" alt="{{ $websiteStatistic->alt_image }}" />
                        </div>
                        <div class="content">
                            <div class="counter-two__count-box">
                                <h3 class="odometer" data-count="{{ $websiteStatistic->count }}">00</h3>
                                <span>+</span>
                            </div>
                            <p class="counter-two__count-text">{{ $websiteStatistic->title }}</p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
@endif
