@props([
    'label', // Label text for the input field.
    'name', // Name attribute for the input field.
    'options', // Options to be displayed in the select field.
    'defaultValue' => null, // Default value of the input field.
    'optionCaptionAttribute' => 'name', // Attribute of each option used as the display caption.
    'baggedErrorName' => false, // Optional: the error bag name for validation messages.
    'required' => $attributes->has('required'), // Whether the field is required (based on attributes).
    'placeholder' => null, // Optional placeholder text for the select field.
])

@php
    // Determine the selected value, preferring old input or the default value.
    $selectedValue = old($name, $defaultValue);
@endphp

{{-- Include the default-group wrapper with proper error handling --}}
<x-form.groups.default-group
    :label="__($label)"
    :error-name="$name"
    :bagged-error-name="$baggedErrorName"
    :required="$required">

    {{-- The select element with dynamic attributes --}}
    <select
        {{ $attributes->merge(['class' => 'select']) }}
        name="{{ $name }}"
        @if ($required) required @endif>

        {{-- Placeholder option, if specified --}}
        @if ($placeholder)
            <option value="" disabled selected>{{ $placeholder }}</option>
        @endif

        {{-- Loop through the options and generate each option tag --}}
        @foreach ($options as $option)
            <option value="{{ $option->id }}" @selected($option->id == $selectedValue)>
                {{ $option->{$optionCaptionAttribute} }}
            </option>
        @endforeach
    </select>

</x-form.groups.default-group>
