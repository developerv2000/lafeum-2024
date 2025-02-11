<x-front.different.leftbar title="Авторы" subtitle="Поиск по имени" include-search="true" search-placeholder="Введите имя автора">
    <nav class="leftbar__nav leftbar__nav--limited-height thin-scrollbar">
        @foreach ($authors as $record)
            <a @class([
                'leftbar__nav-link',
                'leftbar__nav-link--active' => $author->id == $record->id,
            ])
                href="{{ route('authors.show', $record->slug) }}"
                target="_blank">{{ $record->name }}</a>
        @endforeach
    </nav>
</x-front.different.leftbar>
