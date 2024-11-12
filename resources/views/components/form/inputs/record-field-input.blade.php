@props([
    'labelText', // Label text for the input field.
    'model', // Model instance for retrieving field values.
    'field', // Model attribute to display in the input.
    'inputName' => $field, // Name for the input field.
    'validationErrorKey' => null, // Validation error bag key, if any.
    'isRequired' => false, // Determines if the field is required.
])

<x-form.groups.default-group
    :labelText="$labelText"
    :errorFieldName="$inputName"
    :validationErrorKey="$validationErrorKey"
    :isRequired="$isRequired">

    <input
        {{ $attributes->merge(['class' => 'input']) }}
        name="{{ $inputName }}"
        value="{{ old($inputName, $model->{$field}) }}"
        @if ($isRequired) required @endif>
</x-form.groups.default-group>
