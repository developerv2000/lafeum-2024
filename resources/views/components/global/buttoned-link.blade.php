@props(['link', 'style' => 'main', 'icon' => null])

<a {{ $attributes->merge(['class' => 'button button--' . $style]) }} href="{{ $link }}">
    @if ($icon)
        <x-global.material-symbol-outlined class="button__icon" :icon="$icon" />
    @endif

    <span class="button__text">{{ $slot }}</span>
</a>
