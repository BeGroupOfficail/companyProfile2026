@props([
    'label' => 'Default input style',
    'value' => '',
    'class' => 'form-control',
    'name' => '',
    'id' => 'kt_tagify_' . uniqid() // Generate a unique ID
])

<div class="mb-10">
    <label class="form-label">{{ $label }}  <span class="badge badge-light-success"> @lang('dash.type then press enter') </span></label>
    <input {{ $attributes->merge(['class' => $class, 'value' => $value, 'name' => $name, 'id' => $id]) }} />
</div>

@push('scripts')
    <script>
        var input = document.querySelector('#{{ $id }}');
        if (input) {
            new Tagify(input);
        }
    </script>
@endpush
