<x-front.different.leftbar title="Авторы" subtitle="Поиск по имени" include-search="true" search-placeholder="Введите имя автора">
    <nav class="leftbar__nav leftbar__nav--limited-height thin-scrollbar">
        @foreach ($authors as $author)
            <a class="leftbar__nav-link" href="{{ route('authors.show', $author->slug) }}" target="_blank">{{ $author->name }}</a>
        @endforeach
    </nav>
</x-front.different.leftbar>
