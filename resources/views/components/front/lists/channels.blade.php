@props(['recordChunks'])

<div class="default-list channels-list">
    @foreach ($recordChunks as $chunk)
        <div class="channels-list__part">
            @foreach ($chunk as $channel)
                <a class="channels-list__link" href="{{ route('channels.show', $channel->slug) }}" target="_blank">{{ $channel->name }}</a>
            @endforeach
        </div>
    @endforeach
</div>
