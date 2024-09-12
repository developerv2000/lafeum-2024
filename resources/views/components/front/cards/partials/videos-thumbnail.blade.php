@props(['video'])

<div class="videos-card__thumb"
    data-click-action="show-youtube-video-modal"
    data-video-title="{{ $video->title }}"
    data-video-src="{{ $video->embeded_youtube_link }}" >

    <img class="videos-card__thumb-image" src="{{ $video->youtube_thumbnail }}" alt="{{ $video->title }}">
    <span class="videos-card__thumb-duration">{{ $video->duration }} : 00</span>
</div>
