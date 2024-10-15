@props(['title', 'subtitle' => null, 'includeSearch' => false, 'searchPlaceholder' => null])

<aside {{ $attributes->merge(['class' => 'leftbar']) }}>
    {{-- Collapse button --}}
    <button class="collapse-button leftbar__collapse-button" data-click-action="toggle-collapse" data-collapse-selector=".leftbar__collapse">
        <h2 class="main-title collapse-button__text">{{ $title }}</h2>
        <span class="material-symbols-outlined collapse-button__icon">keyboard_arrow_down</span>
    </button>

    <div class="collapse leftbar__collapse">
        <div class="leftbar__body thin-scrollbar">
            @if ($subtitle)
                <h3 class="leftbar__subtitle">{{ $subtitle }}</h3>
            @endif

            @if ($includeSearch)
                <x-front.different.local-search target-selector=".leftbar__nav-link" placeholder="{{ $searchPlaceholder }}" labeled="true" />
            @endif

            {{ $slot }}
        </div>
    </div>
</aside>
