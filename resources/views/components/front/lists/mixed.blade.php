@props(['records', 'relationName', 'modelTypeColumn', 'subtermsArray' => null])

<div class="default-list mixed-list">
    <script>
        var subterms = {{ Illuminate\Support\Js::from($subtermsArray) }};
    </script>

    @foreach ($records as $record)
        @switch($record->{$modelTypeColumn})
            @case('App\Models\Quote')
                <x-front.cards.quotes :quote="$record->{$relationName}" />
            @break

            @case('App\Models\Term')
                <x-front.cards.terms :term="$record->{$relationName}" />
            @break

            @case('App\Models\Video')
                <x-front.cards.videos :video="$record->{$relationName}" />
            @break
        @endswitch
    @endforeach

    {{ $records->links('front.layouts.pagination') }}
</div>
