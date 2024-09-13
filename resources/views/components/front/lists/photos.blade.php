@props(['photos'])

<div class="photos-list">
    @foreach ($photos as $photo)
        <x-front.cards.photos :photo="$photo" />
    @endforeach
</div>

{{ $photos->links('front.layouts.pagination') }}
