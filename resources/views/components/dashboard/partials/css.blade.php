<link rel="canonical" href="{{ url('') }}" />
<link rel="shortcut icon" href="{{($settings?->fav_icon)?Path::uploadedImage('settings',$settings?->fav_icon) : Path::dashboardPath('media/logos/demo.png')}}" />

<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
<link href="{{ Path::dashboardPath('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ Path::dashboardPath('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ Path::dashboardPath('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
<!--end::Global Stylesheets Bundle-->

<!--begin::Fonts(mandatory for all pages)-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
<!--end::Fonts-->

<!--begin::Vendor Stylesheets(used for this page only)-->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link href="{{ Path::dashboardPath('css/custom.style.css') }}" rel="stylesheet" type="text/css" />


<!-- render dashboard main colors-->
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