@props(['record', 'shareUrl'])

<div {{ $attributes->merge(['class' => 'default-card']) }}>
    {{-- Header --}}
    <div class="default-card__header">{{ $header }}</div>

    {{-- Body --}}
    <div class="default-card__body">{{ $body }}</div>

    {{-- Footer --}}
    <div class="default-card__footer">
        <div class="default-card__foter-left">
            <x-front.cards.default.partials.like-form :record="$record" />
            <x-front.cards.default.partials.favorite-form :record="$record" />
        </div>

        <div class="default-card__foter-right">
            <x-front.cards.default.partials.yandex-share :shareUrl="$shareUrl" />
        </div>
    </div>
</div>
