@props(['title' => null, 'desc' => null, 'includeSearch' => false, 'searchSelector' => null])

<div {{ $attributes->merge(['class' => 'about-page']) }}>
    @if ($title)
        <h1 class="main-title about-page__title">{{ $title }}</h1>
    @endif

    @if ($desc)
        <p class="about-page__desc">{!! $desc !!}</p>
    @endif

    @if ($includeSearch)
        <x-front.different.local-search class="about-page__search" target-selector="{{ $searchSelector }}" placeholder="Введите область знаний" />
    @endif
</div>
