@php
    $options = ['published', 'inactive'];
    if($model == 'users') {
        $options = ['active', 'inactive', 'blocked'];
    }

    // Get current status from the database object if available
    $selectedStatus = $attributes->get('selected') ?? ($modelObject->status ?? 'inactive');
@endphp

<div class="card card-flush py-4">
    <div class="card-header">
        <div class="card-title">
            <h2>{{ __('dash.status') }}</h2>
        </div>
    </div>
    <div class="card-body pt-0">
        <select class="form-select mb-2" data-control="select2" data-hide-search="true"
                data-placeholder="Select an option" name="status">
            <option></option>
            @foreach($options as $option)
                <option value="{{ $option }}"
                    @selected($selectedStatus == $option)>
                    {{ __("dash.$option") }}
                </option>
            @endforeach
        </select>
        <div class="text-muted fs-7">
            {{ __('dash.Set the') }}  {{ __('dash.status') }}.
        </div>
    </div>
</div>
