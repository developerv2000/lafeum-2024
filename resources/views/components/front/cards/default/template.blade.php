@props(['record', 'shareUrl'])

<div {{ $attributes->merge(['class' => 'default-card']) }}>
    {{-- Header --}}
    <div class="default-card__header">{{ $header }}</div>

    {{-- Body --}}
    <div class="default-card__body">{{ $body }}</div>

    {{-- Footer --}}
    <div class="default-card__footer">
        <div class="default-card__foter-left">
            @auth
                <x-front.cards.default.partials.auth-like-form :record="$record" />
                <x-front.cards.default.partials.auth-favorite-form :record="$record" />
            @endauth

            @guest
                <x-front.cards.default.partials.guest-like :record="$record" />
                <x-front.cards.default.partials.guest-favorite />
            @endguest
        </div>

        <div class="default-card__foter-right">
            <x-front.cards.default.partials.yandex-share :shareUrl="$shareUrl" />
        </div>
    </div>
</div>
