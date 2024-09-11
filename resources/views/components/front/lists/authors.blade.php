@props(['recordChunks'])

<div class="default-list authors-list">
    @foreach ($recordChunks as $chunk)
        <div class="authors-list__part">
            @foreach ($chunk as $author)
                <a class="authors-list__link" href="{{ route('authors.show', $author->slug) }}" target="_blank">{{ $author->name }}</a>
            @endforeach
        </div>
    @endforeach
</div>
