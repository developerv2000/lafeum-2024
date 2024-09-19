@props(['records', 'subtermsArray' => null])

<div class="default-list mixed-list">
    <script>
        var subterms = {{ Illuminate\Support\Js::from($subtermsArray) }};
    </script>

    @foreach ($records as $record)
        @switch($record->likeable_type)
            @case('App\Models\Quote')
                <x-front.cards.quotes :quote="$record->likeable" />
            @break

            @case('App\Models\Term')
                <x-front.cards.terms :term="$record->likeable" />
            @break

            @case('App\Models\Video')
                <x-front.cards.videos :video="$record->likeable" />
            @break
        @endswitch
    @endforeach

    {{ $records->links('front.layouts.pagination') }}
</div>
