@props(['style' => 'main', 'icon' => null])

<button {{ $attributes->merge(['class' => 'button button--' . $style]) }}>
    @if ($icon)
        <x-global.material-symbol-outlined class="button__icon" :icon="$icon" />
    @endif

    <span class="button__text">{{ $slot }}</span>
</button>
