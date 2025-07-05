@extends('designs::layout.main')

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar breadcrumb-bar-info breadcrumb-info">
        <div class="breadcrumb-img">
            <div class="breadcrumb-left">
                <img src="{{ WebsiteHelper::getAsset('img/bg/banner-bg-03.png') }}" alt="img">
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.html"> @lang('home.home')</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page"> {{ $page->name }}</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">{{ $page->name }}</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->
    <!-- Content -->
    <div class="page-content">
        <div class="container">
            <h1 class="page-title">{{ $page->name }}</h1>
            <div class="col-md-4 col-12">
                <p>
                    {!! $page->short_desc !!}
                </p>
            </div>
            <div class="col-md-8 col-12">
                <p>
                    {!! $page->long_text !!}
                </p>
            </div>
        </div>
    </div>
@endsection
