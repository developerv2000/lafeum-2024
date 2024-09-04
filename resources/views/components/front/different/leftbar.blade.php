@props(['title', 'subtitle' => null, 'includeSearch' => false, 'searchPlaceholder' => null])

<aside {{ $attributes->merge(['class' => 'leftbar']) }}>
    <h2 class="main-title leftbar__title">{{ $title }}</h2>

    <div class="leftbar__body thin-scrollbar">
        @if ($subtitle)
            <h3 class="leftbar__subtitle">{{ $subtitle }}</h3>
        @endif

        @if ($includeSearch)
            <x-front.different.local-search target-selector=".leftbar__nav-link" placeholder="{{ $searchPlaceholder }}" />
        @endif

        {{ $slot }}
    </div>
</aside>
