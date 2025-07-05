@if($workingSteps->count() > 0)
<section class="how-to-work section-space">
    <div class="container">
        <div class="sec-title text-center">
            <h6 class="sec-title__tagline bw-split-in-right">@lang('home.How It Works')</h6><!-- /.sec-title__tagline -->
            <h3 class="sec-title__title bw-split-in-left">@lang('home.How It Works Step by Step')</h3><!-- /.sec-title__title -->
        </div><!-- /.sec-title -->

        <div class="row gutter-y-40">
            @foreach($workingSteps as $workingStep)
                <div class="col-lg-4 col-md-6">
                    <div class="how-to-work__item wow fadeInUp animated" data-wow-duration="1500ms" data-wow-delay="300ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 300ms; animation-name: fadeInUp;">
                        <div class="how-to-work__icon">
                            <img src="{{WebsiteHelper::getImage('about_values',$workingStep->image) }}" alt="{{$workingStep->alt_image}}">

                            <span class="how-to-work__icon__count"></span>
                        </div><!-- /.how-to-work__icon -->
                        <h4 class="how-to-work__title">{{$workingStep->title}} </h4><!-- /.how-to-work__title -->
                        <p class="how-to-work__text">{!! $workingStep->description !!}</p><!-- /.how-to-work__text -->
                    </div><!-- /.how-to-work__item -->
                </div><!-- /.col-lg-4 -->
            @endforeach
        </div><!-- /.row -->
        <div class="how-to-work__shape">
            <img src="{{ WebsiteHelper::getAsset('images/shapes/line-how-to.png') }}" alt="shape">
        </div><!-- /.how-to-work__shape -->
    </div><!-- /.container -->
    <div class="how-to-work__element">
        <img src="{{ WebsiteHelper::getAsset('images/resources/how-lagges.png') }}" alt="shape">
    </div><!-- /.how-to-work__element -->
</section>
@endif
