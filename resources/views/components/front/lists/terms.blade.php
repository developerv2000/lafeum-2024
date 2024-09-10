@props(['terms', 'subtermsArray' => null])

<div class="default-list terms-list">
    <script>
        var subterms = {{ Illuminate\Support\Js::from($subtermsArray) }};
    </script>

    @foreach ($terms as $term)
        <x-front.cards.terms :term="$term" />
    @endforeach

    {{ $terms->links('front.layouts.pagination') }}
</div>
