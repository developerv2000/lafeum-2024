@props(['term'])

<x-front.cards.default.template class="terms-card" :record="$term" :share-url="route('terms.show', $term->id)">
    {{-- Header --}}
    <x-slot:header>
        {{-- Title --}}
        @if ($term->type->isExpertComments())
            {{-- Export comments --}}
            <p class="terms-card__type-name">{{ $term->type->name }}</p>
        @else
            {{-- Scientific terms --}}
            <div class="terms-card__type-icons-wrapper">
                <img class="terms-card__type-icon" src="{{ asset('img/main/atom.svg') }}" alt="atom">
                <img class="terms-card__type-icon" src="{{ asset('img/main/atom.svg') }}" alt="atom">
                <img class="terms-card__type-icon" src="{{ asset('img/main/atom.svg') }}" alt="atom">
            </div>
        @endif

        {{-- ID --}}
        <x-front.cards.default.partials.id :id="$term->id" :link="route('terms.show', $term->id)" />
    </x-slot:header>

    {{-- Body --}}
    <x-slot:body>
        <div class="default-card__body-text terms-card__body-text">{!! $term->body !!}</div>

        {{-- Subterms popup --}}
        <div class="terms-card__popup">
            <div class="terms-card__popup-inner" data-current-subterm-id="0"></div>
        </div>

        <x-front.cards.default.partials.expand-more />
        <x-front.cards.default.partials.categories :categories="$term->categories" link-route-name="terms.category" />
    </x-slot:body>
</x-front.cards.default.template>
