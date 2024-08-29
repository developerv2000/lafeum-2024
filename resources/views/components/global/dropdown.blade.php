@props(['includeArrow' => false])

<div {{ $attributes->merge(['class' => $includeArrow ? 'dropdown dropdown--arrowed' : 'dropdown']) }}>
    <button class="dropdown__button" aria-expanded="false" aria-controls="dropdown-content">
        {{ $button }}

        @if ($includeArrow)
            <x-global.material-symbol-outlined class="dropdown__icon" icon="arrow_drop_down" />
        @endif
    </button>

    <ul class="dropdown__content" role="menu">
        {{ $content }}
    </ul>
</div>
