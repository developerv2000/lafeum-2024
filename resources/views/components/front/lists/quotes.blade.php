@props(['quotes'])

<div class="default-list quotes-list">
    @foreach ($quotes as $quote)
        <x-front.cards.quotes :quote="$quote" />
    @endforeach

    {{ $quotes->links('front.layouts.pagination') }}
</div>
