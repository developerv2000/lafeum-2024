@props([
    'label', // The label text displayed for the input field.
    'name', // The 'name' attribute for the input field.
    'value' => null, // The initial value of the input field.
    'baggedErrorName' => false, // Optional: the error bag name for validation messages.
    'required' => $attributes->has('required'), // Whether the field is required (based on attributes).
])

{{-- Include the default-group wrapper with proper error handling --}}
<x-form.groups.default-group
    :label="__($label)"
    :error-name="$name"
    :bagged-error-name="$baggedErrorName"
    :required="$required" >

    {{-- The input field, with merged attributes and old value handling --}}
    <input
        {{ $attributes->merge(['class' => 'input']) }}
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if ($required) required @endif>
</x-form.groups.default-group>
