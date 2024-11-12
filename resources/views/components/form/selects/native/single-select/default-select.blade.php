@props([
    'labelText', // Label text for the input field.
    'inputName', // Name for the input field.
    'options', // Options to be displayed in the select field.
    'initialValue' => null, // Initial value of the input field.
    'validationErrorKey' => null, // Validation error bag key, if any.
    'isRequired' => false, // Determines if the field is required.
    'placeholderText' => null, // Optional placeholder for the select input.
])

@php
    // Set the currently selected option value, preferring old input or the initial value.
    $selectedValue = old($inputName, $initialValue);
@endphp

<x-form.groups.default-group
    :labelText="$labelText"
    :errorFieldName="$inputName"
    :validationErrorKey="$validationErrorKey"
    :isRequired="$isRequired">

    {{-- The select element with dynamic attributes --}}
    <select
        {{ $attributes->merge(['class' => 'select']) }}
        name="{{ $inputName }}"
        @if ($isRequired) required @endif>

        {{-- Placeholder option, if specified --}}
        @if ($placeholderText)
            <option value="" disabled selected>{{ $placeholderText }}</option>
        @endif

        {{-- Loop through the options and generate each option tag --}}
        @foreach ($options as $option)
            <option value="{{ $option }}" @selected($option == $selectedValue)>
                {{ $option }}
            </option>
        @endforeach
    </select>

</x-form.groups.default-group>
