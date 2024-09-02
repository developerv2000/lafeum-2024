@props(['title', 'subtitle' => null, 'includeSearch' => false, 'searchPlaceholder' => null])

<aside {{ $attributes->merge(['class' => 'leftbar']) }}>
    <h2 class="main-title leftbar__title">{{ $title }}</h2>

    <div class="leftbar__body thin-scrollbar">
        @if ($subtitle)
            <h3 class="leftbar__subtitle">{{ $subtitle }}</h3>
        @endif

        @if ($includeSearch)
            <div class="leftbar__search">
                <x-front.different.local-search class="leftbar__search-input" target-selector=".leftbar__link" placeholder="{{ $searchPlaceholder }}" />
            </div>
        @endif

        {{ $slot }}
    </div>
</aside>
