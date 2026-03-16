<!--begin::Aside-->
<div class="d-flex flex-lg-row-fluid">
    <!--begin::Content-->
    <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
        <!--begin::Image-->
        <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="{{ asset('uploads/settings/' . $settings->logo) }}" alt="{{$settings->alt_logo}}" />
        <img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="{{ asset('uploads/settings/' . $settings->wite_logo) }}" alt="{{$settings->alt_wite_logo}}" />
        <!--end::Image-->

        <!--begin::Title-->
        <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">
            {{$settings->site_name}}
{{--            @lang('dash.Learning, Simplified and Streamlined')--}}
        </h1>
        <!--end::Title-->

        <!--begin::Text-->
        <div class="text-gray-600 fs-base text-center fw-semibold">
            {!! $settings->site_desc !!}
{{--            @lang('dash.Say goodbye to complexity. Our LMS makes managing and delivering educational content simple, so you can focus on what matters Learaning Our LMS combines modern technology with traditional learning methods to create a dynamic environment that fosters knowledge and creativity.')--}}
        </div>
        <!--end::Text-->
    </div>
    <!--end::Content-->
</div>
<!--begin::Aside-->
