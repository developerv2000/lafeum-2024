<x-front.different.leftbar title="Каналы" subtitle="Поиск по каналам" include-search="true" search-placeholder="Введите имя канала">
    <nav class="leftbar__nav leftbar__nav--limited-height thin-scrollbar">
        @foreach ($channels as $channel)
            <a @class([
                'leftbar__nav-link',
                'leftbar__nav-link--active' => $record->id == $channel->id,
            ])
                href="{{ route('channels.show', $channel->slug) }}"
                target="_blank">{{ $channel->name }}</a>
        @endforeach
    </nav>
</x-front.different.leftbar>
