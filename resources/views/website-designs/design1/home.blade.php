@extends('designs::layout.main')

@section('content')
    @php
        $sectionMap = [
            'slidersSection' => 'designs::homePartials.slidersSection',
            'aboutSection' => 'designs::homePartials.aboutSection',
            'servicesSection'=>'designs::homePartials.servicesSection',
            'popularToursSection' => 'designs::homePartials.popularToursSection',
            'popularDestinationSection' => 'designs::homePartials.popularDestinationSection',
            'offersSection' => 'designs::homePartials.offersSection',
            'numbersSection' => 'designs::homePartials.numbersSection',
            'howItWorksSection' => 'designs::homePartials.howItWorksSection',
            'whyChooseUsSection' => 'designs::homePartials.whyChooseUsSection',
            'blogsSection' => 'designs::homePartials.blogsSection',
            'instagramSection' => 'designs::homePartials.instagramSection',
        ];
    @endphp


    @foreach ($homepageSections as $homepageSection)
        @php
            $title = $homepageSection->getTranslation('title', 'en');
        @endphp

        @if (isset($sectionMap[$title]))
            @include($sectionMap[$title])
        @endif
    @endforeach

@endsection
