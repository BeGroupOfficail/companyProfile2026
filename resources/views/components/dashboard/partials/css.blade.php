<link rel="canonical" href="{{ url('') }}" />
<link rel="shortcut icon"
    href="{{($settings?->fav_icon) ? Path::uploadedImage('settings', $settings?->fav_icon) : Path::dashboardPath('media/logos/demo.png')}}" />

<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
<link href="{{ Path::dashboardPath('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ Path::dashboardPath('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
    type="text/css" />
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
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid/main.css" rel="stylesheet" />





<!-- render dashboard main colors-->
<style>
    :root {
        --primary_color:
            {{ $settings['primary_color'] ?? '#99A1B7' }}
        ;
        --secondary_color:
            {{ $settings['secondary_color'] ?? '#000' }}
        ;
        --bs-primary:
            {{ $settings['primary_color'] ?? '#99A1B7' }}
        ;
    }


    .primary-color {
        color: var(--primary_color) !important
    }

    .nav-pills-custom .nav-link {
        border: 1px dashed #ccc;
        color: #007bff;
        border-radius: 12px;
        margin-right: 5px;
    }

    .nav-pills-custom .nav-link.active {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }
    .nav.nav-pills.nav-pills-custom .nav-link.active,
    .nav.nav-pills.nav-pills-custom .show > .nav-link.active {
        background-color: var(--bs-primary);
        color: white;
        border: 1px solid var(--bs-primary);
    }

</style>
