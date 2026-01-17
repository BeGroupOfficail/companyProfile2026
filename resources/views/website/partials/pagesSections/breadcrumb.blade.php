<!--Page Header Start-->
<section class="page-header">
    <div class="page-header__bg"></div>
    <div class="container">
        <div class="page-header__inner">
            <h3>{{ $title }}</h3>
            <div class="thm-breadcrumb__inner">
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{ url('/') }}">@lang('home.home_page')</a></li>
                    @foreach($items as $item)
                        <li><span class="icon-arrow-left"></span></li>
                        @if(isset($item['url']))
                            <li><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
                        @else
                            <li>{{ $item['label'] }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
<!--Page Header End-->
