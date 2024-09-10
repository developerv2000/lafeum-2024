@props(['recordChunks'])

<div class="default-list vocabulary-list">
    @foreach ($recordChunks as $chunk)
        <div class="vocabulary-list__part">
            @foreach ($chunk as $term)
                <div class="vocabulary-list__item">
                    <a class="vocabulary-list__link" data-content-loaded="0" data-term-id="{{ $term->id }}" href="{{ route('terms.show', $term->id) }}" target="_blank">{{ $term->name }}</a>
                    <div class="vocabulary-list__popup"></div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
