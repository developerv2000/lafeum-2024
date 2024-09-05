<div class="default-list terms-list">
    @foreach ($terms as $term)
        <x-front.cards.terms :term="$term" />
    @endforeach

    {{ $terms->links('front.layouts.pagination') }}
</div>
