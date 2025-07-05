<!DOCTYPE html>
<html lang="{{LaravelLocalization::getCurrentLocale()}}"  dir="{{LaravelLocalization::getCurrentLocaleDirection()}}">
<head>
    <title>{{$title}}</title>
    <x-authentication.partials.meta/>
    <x-authentication.partials.css/>
</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">

<x-authentication.partials.theme_mode/>

<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Page bg image-->
    <style>
        body {
            background-image: url({{ Path::dashboardPath('media/auth/bg10.jpg') }});
        }

        [data-bs-theme="dark"] body {
            background-image: url({{ Path::dashboardPath('media/auth/bg10-dark.jpg') }});
        }
    </style>
    <!--end::Page bg image-->

    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid login">

       <x-authentication.partials.aside/>

        <!--begin::Body-->
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
            <!--begin::Wrapper-->
            <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                <!--begin::Content-->
                <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">

                    <!--begin::Wrapper-->
                    <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">

                        {{$slot}}
                    </div>
                    <!--end::Wrapper-->

                    <x-authentication.partials.footer/>
                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
<!--end::Root-->

    <x-authentication.partials.js/>
</body>
<!--end::Body-->

</html>
