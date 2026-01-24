@extends('website.layouts.main')
@section('title')
    <title>{{$settings->site_name}} | @lang('home.blogs')</title>
@endsection

@section('content')
    @include('website.partials.pagesSections.breadcrumb', [
        'title' => __('home.blogs'),
        'items' => [
            ['label' => __('home.blogs')]
        ]
    ])

    @include('website.partials.homeSections.blogs')
@endsection
