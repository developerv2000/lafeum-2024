@props(['video'])

<x-front.cards.default.template class="videos-card" :record="$video" :share-url="route('videos.show', $video->id)">
    {{-- Header --}}
    <x-slot:header></x-slot:header>

    {{-- Body --}}
    <x-slot:body>
        <div class="videos-card__top-row">
            {{-- Thumbnail --}}
            <x-front.cards.partials.videos-thumbnail :video="$video" />

            {{-- Title --}}
            <h3 class="videos-card__title" data-click-action="show-youtube-video-modal" data-video-src="{{ $video->embeded_youtube_link }}">
                {{ $video->title }}
            </h3>
        </div>

        {{-- Channel --}}
        <div class="videos-card__channel">
            <img class="videos-card__channel-icon" src="{{ asset('img/main/youtube.svg') }}">

            <a class="videos-card__channel-name" href="{{ route('channels.show', $video->channel->slug) }}" target="_blank">
                {{ $video->channel->name }}
            </a>
        </div>

        <div class="videos-card__bottom-row">
            {{-- Categories --}}
            <x-front.cards.default.partials.categories :categories="$video->categories" link-route-name="videos.category" />

            {{-- ID --}}
            <x-front.cards.default.partials.id :id="$video->id" :link="route('videos.show', $video->id)" />
        </div>
    </x-slot:body>
</x-front.cards.default.template>
