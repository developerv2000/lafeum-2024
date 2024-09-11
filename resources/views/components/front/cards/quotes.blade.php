@props(['quote'])

<x-front.cards.default.template class="quotes-card" :record="$quote" :share-url="route('quotes.show', $quote->id)">
    {{-- Header --}}
    <x-slot:header>
        {{-- Title --}}
        <div class="quotes-card__title">
            <x-global.material-symbol-outlined class="quotes-card__title-icon" icon="person" filled="1" />
            <p class="quotes-card__title-author-name">{{ $quote->author->name }}</p>
        </div>

        {{-- ID --}}
        <x-front.cards.default.partials.id :id="$quote->id" :link="route('quotes.show', $quote->id)" />
    </x-slot:header>

    {{-- Body --}}
    <x-slot:body>
        <div class="default-card__body-text">{!! $quote->body !!}</div>

        <x-front.cards.default.partials.expand-more />
        <x-front.cards.default.partials.categories :categories="$quote->categories" link-route-name="quotes.category" />
    </x-slot:body>
</x-front.cards.default.template>
