@php use App\Helper\Path; @endphp
@props([
    'model' => null,
    'imageModelName' => null,
    'title' => null,
    'name' => null,
    'changeImageText' => null,
    'cancelImageText' => null,
    'removeImageText' => null,
])

@php
    $imagePath =
        $model && $model->$name
            ? asset("uploads/$imageModelName/" . $model->$name)
            : Path::dashboardPath('media/svg/files/blank-image.svg');

    $imagePathDark =
        $model && $model->$name
            ? asset("uploads/$imageModelName/" . $model->$name)
            : Path::dashboardPath('media/svg/files/blank-image-dark.svg');
@endphp

<div class="card card-flush">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>@lang("dash.$title")</h2>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body text-center pt-0">
        <!--begin::Image input placeholder style-->
        @php
            $uniqueClass = 'image-input-placeholder-' . uniqid();
        @endphp

        <style>
            .{{ $uniqueClass }} {
                background-image: url('{{ $imagePath }}');
            }

            [data-bs-theme="dark"] .{{ $uniqueClass }} {
                background-image: url('{{ $imagePathDark }}');
            }
        </style>
        <!--end::Image input placeholder style-->

        <!--begin::Image input-->
        <div class="image-input image-input-empty image-input-outline {{ $uniqueClass }} mb-3"
            data-kt-image-input="true">
            <!--begin::Preview existing image-->
            <div class="image-input-wrapper w-150px h-150px">
            </div>
            <!--end::Preview existing image-->

            <!--begin::Label-->
            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                data-kt-image-input-action="change" data-bs-toggle="tooltip"
                title="{{ $changeImageText ?? __('dash.Change image') }}">
                <i class="ki-outline ki-pencil fs-7"></i>
                <!--begin::Inputs-->
                <input type="file" name="{{ $name }}" accept=".png, .jpg, .jpeg" />
                <input type="hidden" name="{{ $name }}_remove" />
                <!--end::Inputs-->
            </label>
            <!--end::Label-->

            <!--begin::Cancel-->
            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                title="{{ $cancelImageText ?? __('dash.Cancel image') }}">
                <i class="ki-outline ki-cross fs-2"></i>
            </span>
            <!--end::Cancel-->

            <!--begin::Remove-->
            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                title="{{ $removeImageText ?? __('dash.Remove image') }}">
                <i class="ki-outline ki-cross fs-2"></i>
            </span>
            <!--end::Remove-->
        </div>
        <!--end::Image input-->

        <!--begin::Description-->
        <div class="text-muted fs-7">{{ __('dash.only') }} *.png, *.jpg, and *.jpeg
            {{ __('dash.image files are accepted') }}</div>
        <!--end::Description-->
        <!--begin::ALT input-->
            <x-dashboard.partials.html.input name="alt_{{ $name }}" label="" :value="old('alt_' . $name, $model->{'alt_' . $name} ?? '')"
                placeholder="{{ __('dash.alt') }} {{ __($name) }}" />
        <!--end::ALT input-->
    </div>
    <!--end::Card body-->
</div>
