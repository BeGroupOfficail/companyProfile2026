@extends('website.layouts.main')
@section('title')
    <title>{{$settings->site_name}} | @lang('home.home_page')</title>
@endsection

@section('content')
    @php
        $sectionMap = [
            'sliders' => 'website.partials.homeSections.sliders',
            'services' => 'website.partials.homeSections.services',
            'about' => 'website.partials.homeSections.about',
            'our_speciality' => 'website.partials.homeSections.our_speciality',
            'projects' => 'website.partials.homeSections.projects',
            'statistics' => 'website.partials.homeSections.statistics',
            'clients' => 'website.partials.homeSections.clients',
            'blogs' => 'website.partials.homeSections.blogs',
            'contact_us' => 'website.partials.homeSections.contact_us',
        ];
    @endphp

    @foreach ($homepageSections as $homepageSection)
        @php
            $title = strtolower($homepageSection->getTranslation('title', 'en'));
        @endphp

        @if (isset($sectionMap[$title]))
            @include($sectionMap[$title])
        @endif
    @endforeach
@endsection
