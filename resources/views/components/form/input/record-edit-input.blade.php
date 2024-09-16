@props([
    'label', // Label text for the input field.
    'name', // Name attribute for the input field.
    'record', // The record being edited, used to populate the field value.
    'baggedErrorName' => false, // Optional: Custom error name for validation messages.
    'required' => $attributes->has('required'), // Whether the input field is required.
])

{{-- Include the default-group wrapper with proper error handling --}}
<x-form.groups.default-group
    :label="__($label)"
    :error-name="$name"
    :bagged-error-name="$baggedErrorName"
    :required="$required">

    {{-- The input field, with merged attributes and default record value handling --}}
    <input
        {{ $attributes->merge(['class' => 'input']) }}
        name="{{ $name }}"
        value="{{ old($name, $record->{$name}) }}"
        @if ($required) required @endif >

</x-form.groups.default-group>
