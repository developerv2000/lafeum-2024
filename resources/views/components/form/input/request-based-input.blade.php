@props([
    'label', // The label text for the input field.
    'name', // The name of the input field.
    'value' => null, // Default value for the input field
    'errorName' => null, // Case bagged error names is used.
    'required' => $attributes->has('required'), // Indicates whether the input field is required.
])

<x-form.groups.default-group label="{{ __($label) }}" error-name="{{ $errorName ?: $name }}" :required="$required">
    <input
        {{ $attributes->merge(['class' => 'input ' . (request()->has($name) ? 'input--highlight' : '')]) }}
        name="{{ $name }}"
        value="{{ request()->input($name, $value) }}"
        @if ($required) required @endif>
</x-form.groups.default-group>
