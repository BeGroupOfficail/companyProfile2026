@extends('website.layouts.main')
@section('title')
    <title>{{$settings->site_name}} | @lang('home.about_us')</title>
@endsection

@section('content')
    @include('website.partials.pagesSections.breadcrumb', [
        'title' => __('home.about_us'),
        'items' => [
            ['label' => __('home.about_us')]
        ]
    ])

    @include('website.partials.homeSections.about')
    @include('website.partials.homeSections.statistics')
    @include('website.partials.homeSections.our_speciality')
@endsection
