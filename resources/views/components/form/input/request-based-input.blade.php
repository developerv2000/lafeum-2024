@props([
    'label', // Label text for the input field.
    'name', // Name attribute for the input field.
    'value' => null, // The initial value of the input field.
    'baggedErrorName' => false, // Optional: the error bag name for validation messages.
    'required' => $attributes->has('required'), // Whether the field is required (based on attributes).
])

{{-- Include the default-group wrapper with proper error handling --}}
<x-form.groups.default-group
    :label="__($label)"
    :error-name="$name"
    :bagged-error-name="$baggedErrorName"
    :required="$required">

    {{-- The input field, with merged attributes and request based value handling --}}
    <input
        {{ $attributes->merge(['class' => 'input ' . (request()->has($name) ? 'input--highlight' : '')]) }}
        name="{{ $name }}"
        value="{{ request()->input($name, $value) }}"
        @if ($required) required @endif>

</x-form.groups.default-group>
