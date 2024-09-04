@props(['targetSelector'])

<div {{ $attributes->merge(['class' => 'local-search']) }}>
    <input {{ $attributes->merge(['class' => 'local-search__input']) }} type="text" data-action="local-search" data-target-selector="{{ $targetSelector }}">
    <x-global.button class="local-search__button" style="main" text="Поиск">Поиск</x-global.button>
</div>
