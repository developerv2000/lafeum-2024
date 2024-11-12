@props([
    'labelText', // Label text for the input field.
    'inputName', // Name for the input field.
    'options', // Options to be displayed in the select field.
    'requestedInput' => str_replace('[]', '', $inputName), // Input name with removed brackets.
    'initialValues' => [], // Initial values of the input field.
    'validationErrorKey' => null, // Validation error bag key, if any.
    'isRequired' => false, // Determines if the field is required.
])

@php
    // Set the currently selected option value, preferring request input or the initial value.
    $selectedValues = request()->input($requestedInput, $initialValues);
@endphp

<x-form.groups.default-group
    :labelText="$labelText"
    :errorFieldName="$inputName"
    :validationErrorKey="$validationErrorKey"
    :isRequired="$isRequired">

    <select
        {{ $attributes->merge([
            'class' => $taggable ? 'multiple-taggable-selectize' : 'multiple-selectize' . (request()->has($requestedInput) ? ' multiple-selectize--highlight' : ''),
        ]) }}
        name="{{ $inputName }}"
        multiple
        @if ($isRequired) required @endif>

        {{-- Loop through the options and generate each option tag --}}
        @foreach ($options as $option)
            <option value="{{ $option }}" @selected(in_array($option, $selectedValues))>
                {{ $option }}
            </option>
        @endforeach
    </select>

</x-form.groups.default-group>
