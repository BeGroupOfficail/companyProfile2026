@can($modelName . '.update')
    <a href="{{ $editUrl }}" class="btn btn-icon btn-light-primary btn-active-color-light btn-sm me-1 btn_edit"
        title="{{ __('dash.edit') }}">
        <i class="ki-outline ki-pencil fs-2"></i>
    </a>

    @if (!isset($has_status))
        <a href="javascript:;" class="btn btn-icon btn-light btn-active-color-info btn-sm me-1 btn_active"
            data-change_status_route="{{ isset($routeName) ? route($routeName . '.index') : '' }}"
            data-model_name="{{ $modelName ?? '' }}" title="{{ __('dash.change_status') }}">
            <i class="ki-outline ki-switch fs-2"></i>
        </a>
    @endif

@endcan

@can($modelName . '.delete')
    @if (!isset($hasDelete))
        <a href="javascript:;" class="btn btn-icon btn-light-danger btn-active-color-light btn-sm btn_delete_record"
            title="{{ trans('dash.delete') }}"
            data-delete_route="{{ isset($routeName) ? route($routeName . '.index') : '' }}"
            title="{{ __('dash.delete') }}">
            <i class="ki-outline ki-trash fs-2"></i>
        </a>
    @endif
@endcan

@can($modelName . '.read')
    @if (isset($showUrl))
        <a href="{{ $showUrl ?? '#' }}" class="btn btn-icon btn-light-primary btn-active-color-light btn-sm"
            title="{{ trans('dash.read') }}" target="_blank">
            <i class="ki-outline ki-eye fs-2"></i>
        </a>
    @endif
@endcan
