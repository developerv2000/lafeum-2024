<aside class="rightbar">
    {{-- Collapse button --}}
    <button class="collapse-button rightbar__collapse-button" data-click-action="toggle-collapse" data-collapse-selector=".rightbar__collapse">
        <h3 class="main-title collapse-button__text">Материал дня</h3>
        <span class="material-symbols-outlined collapse-button__icon">keyboard_arrow_down</span>
    </button>

    {{-- Collapse --}}
    <div class="collapse rightbar__collapse">
        <div class="rightbar__body">
            {{-- Quote --}}
            <div class="rightbar__item">
                <h3 class="rightbar__item-title">
                    Цитата дня
                    <x-global.material-symbol-outlined icon="more_horiz" />
                </h3>

                <div class="rightbar__quote">
                    <div class="rightbar__quote-header">
                        <h4 class="rightbar__quote-author">
                            <a href="{{ route('authors.show', $todaysPost->quote->author->slug) }}" target="_blank">{{ $todaysPost->quote->author->name }}</a>
                        </h4>

                        <img class="rightbar__quote-image" src="{{ $todaysPost->quote->author->photo_asset_url }}" alt="{{ $todaysPost->quote->author->name }}">
                    </div>

                    <div class="rightbar__quote-body">{!! $todaysPost->quote->body !!}</div>
                </div>

                <x-front.different.rightbar-more link="{{ route('quotes.index') }}" />
            </div>

            {{-- Term --}}
            <div class="rightbar__item">
                <h3 class="rightbar__item-title">Термин дня</h3>

                <div class="rightbar__term">
                    <div class="rightbar__term-body">{!! $todaysPost->term->body !!}</div>
                </div>

                <x-front.different.rightbar-more link="{{ route('terms.index') }}" />
            </div>

            {{-- Video --}}
            <div class="rightbar__item">
                <h3 class="rightbar__item-title">Видео дня</h3>

                <div class="rightbar__video">
                    <x-front.cards.partials.videos-thumbnail :video="$todaysPost->video" />

                    <p class="rightbar__video-body">{{ $todaysPost->video->title }}</p>
                </div>

                <x-front.different.rightbar-more link="{{ route('videos.index') }}" />
            </div>

            {{-- Photo --}}
            <div class="rightbar__item">
                <h3 class="rightbar__item-title">Фотография дня</h3>

                <div class="rightbar__photo">
                    <img class="rightbar__photo-image"
                        src="{{ $todaysPost->photo->thumb_asset_url }}"
                        alt="Изображение дня"
                        data-click-action="show-photos-modal"
                        data-photo-src="{{ $todaysPost->photo->asset_url }}"
                        data-photo-desc="{{ $todaysPost->photo->description }}">

                    <p class="rightbar__photo-body">{{ $todaysPost->photo->description }}</p>
                </div>

                <x-front.different.rightbar-more link="{{ route('photos.index') }}" />
            </div>
        </div>
    </div>
</aside>
