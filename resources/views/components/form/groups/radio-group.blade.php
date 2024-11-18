@props([
    'labelText', // Label text for the form field.
    'errorFieldName' => null, // Field name for validation.
    'validationErrorKey' => null, // Error bag for validation messages.
    'isRequired' => false, // Indicates if the field is required (defaults to false).
    'icon' => 'error', // Default icon for errors (can be customized for different contexts).
])

@php
    $inputErrors = $validationErrorKey ? $errors->{$validationErrorKey} : $errors;
    $hasError = $errorFieldName && $inputErrors->has($errorFieldName);
@endphp

<div {{ $attributes->merge(['class' => 'form-group radio-group' . ($hasError ? ' form-group--error' : '')]) }}>
    {{-- Render the label and indicate if the field is required --}}
    <label class="label">
        <p class="label__text">
            {{ __($labelText) }}

            @if ($isRequired)
                <span class="label__required">*</span>
            @endif
        </p>
    </label>

    <div class="form-group__input-container radio-group__options-container">
        {{-- Render the slot (usually an input field) --}}
        {{ $slot }}
    </div>

    {{-- Display the first error message if there is one --}}
    {{-- blade-formatter-disable-next-line --}}
    <p class="form-group__error-message">@if ($hasError){{ $inputErrors->first($errorFieldName) }}@endif</p>
</div>
