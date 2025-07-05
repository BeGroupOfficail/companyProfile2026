<!DOCTYPE html>
<html class="no-js" lang="{{ $lang == 'en' ? 'en' : 'ar' }}" dir="{{ $lang == 'en' ? 'ltr' : 'rtl' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- seo data -->
        @isset($seoData)
            {!! seo($seoData) !!}
        @endisset

        <!-- fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Just+Another+Hand&amp;family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&amp;display=swap" rel="stylesheet">


        <link rel="stylesheet" href="{{ WebsiteHelper::getAsset('vendors/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ WebsiteHelper::getAsset('vendors/bootstrap-select/bootstrap-select.min.css') }}">
        <link rel="stylesheet" href="{{ WebsiteHelper::getAsset('vendors/animate/animate.min.css') }}'">
        <link rel="stylesheet" href="{{ WebsiteHelper::getAsset('vendors/fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ WebsiteHelper::getAsset('vendors/jquery-ui/jquery-ui.css') }}">
        <link rel="stylesheet" href="{{ WebsiteHelper::getAsset('vendors/jarallax/jarallax.css') }}">
        <link rel="stylesheet" href="{{ WebsiteHelper::getAsset('vendors/jquery-magnific-popup/jquery.magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ WebsiteHelper::getAsset('vendors/nouislider/nouislider.min.css') }}">
        <link rel="stylesheet" href="{{ WebsiteHelper::getAsset('vendors/nouislider/nouislider.pips.css') }}">
        <link rel="stylesheet" href="{{ WebsiteHelper::getAsset('vendors/gotur-icons/style.css') }}">
        <link rel="stylesheet" href="{{ WebsiteHelper::getAsset('vendors/daterangepicker-master/daterangepicker.css') }}">
        <link rel="stylesheet" href="{{ WebsiteHelper::getAsset('vendors/owl-carousel/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ WebsiteHelper::getAsset('vendors/owl-carousel/css/owl.theme.default.min.css') }}">
        <link rel="stylesheet" href="{{ WebsiteHelper::getAsset('vendors/slick-carousel/slick.css') }}">

        <!-- template styles -->
        <link rel="stylesheet" href="{{ WebsiteHelper::getAsset('css/style.css') }}">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    </head>

    <body class="custom-cursor">

        <div class="custom-cursor__cursor"></div>
        <div class="custom-cursor__cursor-two"></div>

        <!-- /.preloader -->
        <div class="preloader">
            <div class="preloader__image" style="background-image: url(assets/images/loader.png);"></div>
        </div>

        <!-- /.page-wrapper -->
        <div class="page-wrapper">

            @include('designs::layout.header')

            @yield('content')

            @include('designs::layout.footer')
        </div>

        @include('designs::layout.mobileNav')

        @include('designs::layout.searchSection')

        @include('designs::layout.drowerPanel')

        <div id="scroll-top" class="scroll-top">
            <span id="scroll-top-value" class="scroll-top-value"></span>
        </div>

        <script src="{{ WebsiteHelper::getAsset('vendors/jquery/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/bootstrap-select/bootstrap-select.min.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/jarallax/jarallax.min.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/jquery-ui/jquery-ui.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/jquery-appear/jquery.appear.min.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/jquery-circle-progress/jquery.circle-progress.min.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/jquery-magnific-popup/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/jquery-validate/jquery.validate.min.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/nouislider/nouislider.min.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/wnumb/wNumb.min.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/owl-carousel/js/owl.carousel.min.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/slick-carousel/slick.min.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/wow/wow.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/imagesloaded/imagesloaded.min.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/isotope/isotope.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/countdown/countdown.min.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/daterangepicker-master/moment.min.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/daterangepicker-master/daterangepicker.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/jquery-circleType/jquery.circleType.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/jquery-lettering/jquery.lettering.min.js') }}"></script>

        <!-- GSAP -->
        <script src="{{ WebsiteHelper::getAsset('vendors/gsap/gsap.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/gsap/scrollTrigger.min.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/gsap/splittext.min.js') }}"></script>
        <script src="{{ WebsiteHelper::getAsset('vendors/gsap/gotur-gsap.js') }}"></script>

        <!-- template js -->
        <script src="{{ WebsiteHelper::getAsset('js/main.js') }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <script>
            toastr.options = {
                "closeButton": true,
                "newestOnTop": true,
                "progressBar": false,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
            };
        </script>

        @if (session('success'))
            <script>
                toastr.success('{{ session('success') }}');
            </script>
        @elseif (session('errors'))
            @foreach ($errors->all() as $error)
                <script>
                    toastr.error('{{ $error }}');
                </script>
            @endforeach
        @elseif (session('error'))
            <script>
                toastr.error('{{ session('error') }}');
            </script>
        @endif
        @yield('scripts')
    </body>
</html>
