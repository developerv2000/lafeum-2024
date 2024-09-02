@props(['video'])

<div class="video-card__thumb">
    <img class="video-card__thumb-image"
        src="{{ $video->youtube_thumbnail }}"
        data-action="display-youtube-video-modal"
        data-youtube-video-src="{{ $video->youtube_embeded_link }}"
        data-youtube-video-title="{{ $video->title }}"
        alt="{{ $video->title }}">

    <span class="video-card__thumb-duration">{{ $video->duration }} : 00</span>
</div>
