@props([
    'label', // The label text for the input field.
    'name', // The name of the input field.
    'value' => null, // Default value for the input field
    'errorName' => null, // Case bagged error names is used.
    'rows' => 5, // Rows count of the input field
    'required' => $attributes->has('required'), // Indicates whether the input field is required.
])

<x-form.groups.default-group :label="__($label)" :error-name="$errorName ?: $name" :required="$required">
    <textarea
        {{ $attributes->merge(['class' => 'textarea ' . (request()->has($name) ? 'textarea--highlight' : '')]) }}
        name="{{ $name }}"
        rows={{ $rows }}
        @if ($required) required @endif>{{ request()->input($name, $value) }}</textarea>
</x-form.groups.default-group>
