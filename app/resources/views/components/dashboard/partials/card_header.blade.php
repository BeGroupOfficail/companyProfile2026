@php

    $importRoute = $importRoute ?? false;
    $hasImport = $hasImport ?? false;
    $param = $param ?? false;
    $noRoute = $noRoute ?? false;
    $route = isset($routeName) ? $routeName . '.create' : $title . '.create';
    if ($modelName == 'users') {
        $user_type = request()->get('type');
    }
    use App\Helper\instructor;

    $showHeader = $showHeader ?? true;
@endphp

<!--begin::Card header-->
<div class="card-header border-0 pt-6" data-select2-id="select2-data-141-d21i">

    @if (!Route::is('dashboard.home') && $showHeader)
        <!--begin::Card title-->
        <div class="card-title top-header">

            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">{{__("dash.$title")}}</h1>
                <!--end::Title-->

                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('dashboard.home')}}"
                           class="text-muted text-hover-primary">{{__('dash.dashboard')}} </a>
                    </li>
                    <!--end::Item-->

                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->

                    @yield('breadcrumbs')

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">{{__("dash.$title")}} </li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
        </div>
        <!--begin::Card title-->
    @endif


    <!--begin::Card toolbar-->
    <div class="card-toolbar" data-select2-id="select2-data-140-pl5a">
        <!--begin::Toolbar-->
        <div class="card-toolbar flex-row-fluid justify-content-end gap-5" data-select2-id="select2-data-132-ydav">

            @can($modelName . '.read')
                @if (!isset($hasCreate))
                        <a type="button" class="btn btn-primary"
                           href="{{ !$noRoute ? (isset($param) ? route($route, $param) : route($route)) : '' }}">
                            <i class="ki-outline ki-add-item fs-2"></i> {{ __('dash.add') }} {{ __("dash.$title") }}
                        </a>
                @endif

                @if ($hasImport && \App\Models\Dashboard\SystemFile\SystemFile::where('type', $hasImport)->exists())
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#importModal">
                        <i class="ki-outline ki-file fs-2"></i> {{ __('dash.add') }} {{ __('dash.import_with_excel') }}
                    </button>


                    <!-- Import Modal -->
                    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                         aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="importModalLabel">{{ __('dash.import_with_excel') }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!--begin::Alert-->
                                    <div class="alert alert-info d-flex align-items-center p-5 mb-5">
                                        <i class="ki-outline ki-information-2 fs-2hx text-info me-4"></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-info">{{ __('dash.import_guide') }}</h4>
                                            <a href="{{ asset('uploads/settings/' . $excelGuideFile?->file_name) }}"
                                               class="btn btn-sm btn-light-info mt-3" download>
                                                <i class="ki-outline ki-download fs-2"></i>
                                                {{ __('dash.download_sample_file') }}
                                            </a>
                                        </div>
                                    </div>
                                    <!--end::Alert-->
                                    <form method="POST" action="{{ route($importRoute) }}" id="importForm"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="importFile"
                                                   class="form-label">{{ __('dash.choose_file') }}</label>
                                            <input class="form-control" type="file" id="importFile"
                                                   name="excel_file"
                                                   accept=".xlsx,.xls,.csv" required>
                                        </div>
                                        <button type="submit"
                                                class="btn btn-primary">{{ __('dash.import') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.getElementById('importFile').addEventListener('change', function (e) {
                            const file = e.target.files[0];
                            const preview = document.getElementById('filePreview');
                            if (file) {
                                preview.innerHTML =
                                    `<div class="alert alert-info">{{ __('dash.selected_file') }}: <strong>${file.name}</strong></div>`;
                            } else {
                                preview.innerHTML = '';
                            }
                        });
                    </script>
                @endif
            @endcan

            @if (!isset($hasStatus))
                <a type="button" class="btn btn-secondary btn_change_status" href='javascript:;'
                   id="change-status-btn" data-model_name="{{ $modelName }}"
                   data-change_status_route="{{ isset($routeName) ? route($routeName . '.index') : '' }}"
                   style="display: none;">
                    <i class="ki-outline ki-switch fs-2"></i> {{ __('dash.change status') }}
                </a>
            @endif

            @if (!isset($hasDelete))
                <a type="button" class="btn btn-danger btn_delete" href='javascript:;' id="delete-all-btn"
                   data-delete_route="{{ isset($routeName) ? route($routeName . '.index') : '' }}"
                   style="display: none;">
                    <i class="ki-outline ki-trash fs-2"></i> {{ __('dash.delete') }}
                </a>
            @endif
        </div>

        <!--end::Toolbar-->
    </div>
    <!--end::Card toolbar-->
</div>
<!--end::Card header-->
