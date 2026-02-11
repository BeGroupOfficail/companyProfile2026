<!--begin::Footer-->
<div id="kt_app_footer" class="app-footer " >

    <!--begin::Footer container-->
    <div class="app-container  container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3 ">
        <!--begin::Copyright-->
        <div class="text-gray-900 order-2 order-md-1">
            <p>All Rights Reserved , Developed and Designed by <a href="javascript:void(0);">{{$settings->site_name}}</a></p>
        </div>
        <!--end::Copyright-->

        <!--begin::Menu-->
        <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
            @foreach ($pages->take(3) as $page)
                <li class="menu-item">
                    <a href="{{ LaravelLocalization::localizeUrl('page/' . $page->slug) }}" target="_blank" class="menu-link px-2">{{ $page->name }}</a>
                </li>
            @endforeach

        </ul>
        <!--end::Menu-->
    </div>
    <!--end::Footer container-->
</div>
<!--end::Footer-->
