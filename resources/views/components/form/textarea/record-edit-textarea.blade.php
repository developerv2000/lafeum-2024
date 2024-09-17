@props([
    'label', // Label text for the input field.
    'name', // Name attribute for the input field.
    'record', // Record being edited, used to populate the field value.
    'baggedErrorName' => false, // Optional: the error bag name for validation messages.
    'rows' => 5, // Rows count of the input field
    'required' => $attributes->has('required'), // Whether the field is required (based on attributes).
])

{{-- Include the default-group wrapper with proper error handling --}}
<x-form.groups.default-group
    :label="__($label)"
    :error-name="$name"
    :bagged-error-name="$baggedErrorName"
    :required="$required">

    {{-- The input field, with merged attributes and default record value handling --}}
    <textarea
        {{ $attributes->merge(['class' => 'textarea']) }}
        name="{{ $name }}"
        rows={{ $rows }}
        @if ($required) required @endif>{{ old($name, $record->{$name}) }}</textarea>
</x-form.groups.default-group>
