@extends('website.layouts.main')
@section('title')
    <title>{{$settings->site_name}} | @lang('home.services')</title>
@endsection

@section('content')
    @include('website.partials.pagesSections.breadcrumb', [
        'title' => __('home.services'),
        'items' => [
            ['label' => __('home.services')]
        ]
    ])

    @include('website.partials.pagesSections.services')
@endsection
