@extends('website.layouts.main')
@section('title')
    <title>{{$settings->site_name}} | @lang('home.contact_us')</title>
@endsection

@section('content')

    @include('website.partials.pagesSections.breadcrumb', [
        'title' => __('home.contact_us'),
        'items' => [
            ['label' => __('home.contact_us')]
        ]
    ])

    @include('website.partials.homeSections.contact_us')
@endsection
