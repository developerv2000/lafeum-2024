@props(['record', 'shareUrl'])

<div {{ $attributes->merge(['class' => 'default-card']) }}>
    {{-- Header --}}
    <div class="default-card__header">{{ $header }}</div>

    {{-- Body --}}
    <div class="default-card__body">{{ $body }}</div>

    {{-- Footer --}}
    <div class="default-card__footer">
        <x-front.cards.default.partials.like :record="$record" />
        <x-front.cards.default.partials.yandex-share :shareUrl="$shareUrl" />
    </div>
</div>
