@props([
    'label', // Label text for the form field.
    'required' => false, // Indicates whether the field is required (defaults to false).
    'errorName' => false, // The name of the input field used to check for errors.
    'baggedErrorName' => false, // The error bag name for validation messages (if any).
])

{{-- If an error name is provided, check for errors in the appropriate bag --}}
@if ($errorName)
    @php
        // Select the correct error bag or use default errors object.
        $inputErrors = $baggedErrorName ? $errors->{$baggedErrorName} : $errors;
        // Check if there's an error for the given field name.
        $hasError = $inputErrors->has($errorName);
    @endphp
@endif

<div {{ $attributes->merge(['class' => 'form-group ' . ($hasError ? 'form-group--error' : '')]) }}>
    <label class="label">
        {{-- Render the label and indicate if the field is required --}}
        <p class="label__text">
            {{ $label }}
            @if ($required)
                <span class="label__required">*</span>
            @endif
        </p>

        <div class="form-group__input-container">
            {{-- Render the slot (usually an input field) --}}
            {{ $slot }}

            {{-- Show an error icon if there's an error --}}
            @if ($hasError)
                <span class="form-group__error-icon material-symbols-outlined">error</span>
            @endif
        </div>
    </label>

    {{-- Display the first error message if there is one --}}
    @if ($hasError)
        <p class="form-group__error-message">{{ $inputErrors->first($errorName) }}</p>
    @endif
</div>
