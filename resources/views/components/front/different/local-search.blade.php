@props(['targetSelector', 'placeholder' => null, 'labeled' => false, 'clearable' => true])

<div {{ $attributes->merge(['class' => 'local-search' . ($labeled ? ' local-search--labeled' : '')]) }}>
    <div class="local-search__input-wrapper">
        <input
            class="local-search__input"
            type="text"
            placeholder="{{ $labeled ? null : $placeholder }}"
            data-action="local-search"
            data-target-selector="{{ $targetSelector }}">

        @if ($labeled)
            <label class="local-search__label">{{ $placeholder }}</label>
        @endif

        @if ($clearable)
            <x-global.material-symbol-outlined icon="close" class="local-search__clear-button" />
        @endif
    </div>

    <x-global.button class="local-search__button" style="main" text="Поиск">Поиск</x-global.button>
</div>
