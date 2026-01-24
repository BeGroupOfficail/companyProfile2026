<!--begin::Javascript-->

<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ Path::dashboardPath('plugins/global/plugins.bundle.js')}}"></script>
<script src="{{ Path::dashboardPath('js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<script>
    const translations = {
        login_success: @json(__('auth.You have successfully logged in!')),
        ok: @json(__('auth.Ok_got_it')),
        login_error: @json(__('auth.Sorry, the email or password is incorrect, please try again.')),
    };
</script>
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{ Path::dashboardPath('js/custom/authentication/sign-in/general.js')}}"></script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
