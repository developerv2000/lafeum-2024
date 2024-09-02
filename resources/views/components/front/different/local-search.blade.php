@props(['targetSelector'])

<input {{ $attributes->merge(['class' => 'local-search']) }} type="text" data-action="local-search" data-target-selector="{{ $targetSelector }}">
