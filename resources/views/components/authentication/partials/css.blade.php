<link rel="canonical" href="sign-in.html" />
<link rel="shortcut icon" href="{{asset('uploads/settings/' . $settings?->logo)}}" />

<!--begin::Fonts(mandatory for all pages)-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" /> <!--end::Fonts-->

<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
<link href="{{ Path::dashboardPath('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ Path::dashboardPath('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ Path::dashboardPath('css/custom.style.css') }}" rel="stylesheet" type="text/css" />
<style>
    :root {
        --primary_color: {{ $settings['primary_color'] ?? '#99A1B7' }};
        --secondary_color: {{ $settings['secondary_color'] ?? '#000' }};
        --bs-primary: {{ $settings['primary_color'] ?? '#99A1B7' }}; 
    }
 

    .primary-color {
        color: var(--primary_color) !important
    }
</style>
<!--end::Global Stylesheets Bundle-->
