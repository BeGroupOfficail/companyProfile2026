@extends('website.layouts.main')
@section('title')
    <title>{{$settings->site_name}} | @lang('home.clients')</title>
@endsection

@section('content')
    @include('website.partials.pagesSections.breadcrumb', [
        'title' => __('home.clients'),
        'items' => [
            ['label' => __('home.clients')]
        ]
    ])

    @include('website.partials.pagesSections.clients')

@endsection
