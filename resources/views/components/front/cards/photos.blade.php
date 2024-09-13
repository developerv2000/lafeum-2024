@props(['photo'])

<div class="photos-card">
    <img
        class="photos-card__image"
        src="{{ $photo->thumb_asset_path }}"
        data-click-action="show-photos-modal"
        data-photo-src="{{ $photo->asset_path }}"
        data-photo-desc="{{ $photo->description }}">

    <p class="photos-card__desc">{{ $photo->description }}</p>
</div>
