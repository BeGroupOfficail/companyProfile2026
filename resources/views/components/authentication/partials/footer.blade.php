<!--begin::Footer-->
<div class=" d-flex flex-stack">
    <!--begin::Languages-->
    <div class="me-10">
        <!--begin::Toggle-->
        <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
            @if (LaravelLocalization::getCurrentLocale() == 'en')
                <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="{{ Path::dashboardPath('media/flags/united-states.svg') }}" alt="en lang flag" />
            @elseif(LaravelLocalization::getCurrentLocale() == 'ar')
                <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="{{ Path::dashboardPath('media/flags/saudi-arabia.svg') }}" alt="ar lang flag" />
            @endif
            <span data-kt-element="current-lang-name" class="me-1">{{LaravelLocalization::getCurrentLocaleName()}}</span>
            <i class="ki-outline ki-down fs-5 text-muted rotate-180 m-0"></i>
        </button>
        <!--end::Toggle-->

        <!--begin::Menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
            <!--begin::Menu item-->
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="menu-link d-flex px-5 @if($localeCode == LaravelLocalization::getCurrentLocale()) active @endif">
                                <span class="symbol symbol-20px me-4">
                                    @if ($localeCode == 'en')
                                        <img class="rounded-1"
                                             src="{{ Path::dashboardPath('media/flags/united-states.svg') }}"
                                             alt="united-states flag" />
                                    @elseif($localeCode == 'ar')
                                        <img class="rounded-1"
                                             src="{{ Path::dashboardPath('media/flags/saudi-arabia.svg') }}"
                                             alt="saudi-arabia flag" />
                                    @endif
                                </span>
                        {{ $properties['native'] }}
                    </a>
                </div>
                <!--end::Menu item-->
            @endforeach
            <!--end::Menu item-->

        </div>
        <!--end::Menu-->
    </div>
    <!--end::Languages-->

    <!--begin::Links-->
    <div class="d-flex fw-semibold text-primary fs-base gap-5">
        @foreach ($pages->take(3) as $page)
            <a href="{{ LaravelLocalization::localizeUrl('pages/' . $page->slug) }}" target="_blank">{{ $page->name }}</a>
        @endforeach
    </div>
    <!--end::Links-->
</div>
<!--end::Footer-->
