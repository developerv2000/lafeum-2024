@props([
    'labelText', // Label for the select input.
    'model', // Model instance being edited to populate the selected option.
    'field', // Model attribute to select as default.
    'options', // Collection of available options for selection.
    'inputName' => $field, // Name for the input field.
    'validationErrorKey' => null, // Validation error bag key, if any.
    'isRequired' => false, // If true, marks the field as required.
    'placeholderText' => null, // Optional placeholder for the select input.
])

@php
    // Set the currently selected option value, preferring old input or the model's current value.
    $currentValue = old($inputName, $model->{$field});
@endphp

<x-form.groups.default-group
    :labelText="$labelText"
    :errorFieldName="$inputName"
    :validationErrorKey="$validationErrorKey"
    :isRequired="$isRequired">

    <select
        {{ $attributes->merge(['class' => 'select']) }}
        name="{{ $inputName }}"
        @if ($isRequired) required @endif>

        {{-- Display placeholder option if provided --}}
        @if ($placeholderText)
            <option value="" disabled selected>{{ $placeholderText }}</option>
        @endif

        {{-- Generate options dynamically from the provided collection --}}
        @foreach ($options as $option)
            <option value="{{ $option }}" @selected($option == $currentValue)>
                {{ $option }}
            </option>
        @endforeach
    </select>

</x-form.groups.default-group>
