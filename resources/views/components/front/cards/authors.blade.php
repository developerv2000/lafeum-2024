<div class="authors-card">
    @if ($author->photo_asset_path)
        <img class="authors-card__image" src="{{ $author->photo_asset_path }}" alt="{{ $author->name }}">
    @endif

    <div class="authors-card__body">
        <h1 class="authors-card__title">{{ $author->name }}</h1>
        <div class="authors-card__biography">{!! $author->biography !!}</div>
    </div>
</div>
