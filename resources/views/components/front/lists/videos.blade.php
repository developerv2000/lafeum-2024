@props(['videos'])

<div class="default-list videos-list">
    @foreach ($videos as $video)
        <x-front.cards.videos :video="$video" />
    @endforeach

    {{ $videos->links('front.layouts.pagination') }}
</div>
