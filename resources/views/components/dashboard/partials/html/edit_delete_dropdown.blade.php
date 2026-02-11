@php
    use App\Helper\instructor;
@endphp
@if (isset($editUrl))
        <a href="{{ $editUrl }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 btn_edit">
            <i class="ki-outline ki-pencil fs-2"></i>
        </a>
    @endif
@if (!instructor::isInstructor())
    @if (isset($detailsUrl))
        <a href="{{ $detailsUrl }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 btn_edit">
            <i class="ki-outline ki-eye fs-2"></i>
        </a>
    @endif
        
    <a href="javascript:;" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm btn_delete_record"
        data-delete_route="{{ isset($routeName) ? route($routeName . '.index') : '' }}">
        <i class="ki-outline ki-trash fs-2"></i>
    </a>
@endif
