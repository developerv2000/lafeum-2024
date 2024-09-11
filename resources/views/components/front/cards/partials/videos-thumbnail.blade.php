@props(['video'])

<div class="videos-card__thumb">
    <img class="videos-card__thumb-image"
        src="{{ $video->youtube_thumbnail }}"
        data-action="display-youtube-video-modal"
        data-youtube-video-src="{{ $video->youtube_embeded_link }}"
        data-youtube-video-title="{{ $video->title }}"
        alt="{{ $video->title }}">

    <span class="videos-card__thumb-duration">{{ $video->duration }} : 00</span>
</div>
