<nav {{ $attributes->merge(['class' => 'navbar']) }}>
    <a class="navbar__link" href="{{ route('home') }}">
        <span class="material-symbols-outlined">home</span> Главная
    </a>

    <a class="navbar__link" href="{{ route('knowledge.index') }}">
        <span class="material-symbols-outlined">book_5</span> Области знаний
    </a>

    <a class="navbar__link" href="{{ route('vocabulary.index') }}">
        <span class="material-symbols-outlined">dictionary</span> Словарь
    </a>

    <a class="navbar__link" href="{{ route('quotes.index') }}">
        <span class="material-symbols-outlined">format_quote</span> Цитаты
    </a>

    <a class="navbar__link" href="{{ route('authors.index') }}">
        <span class="material-symbols-outlined">group</span> Авторы
    </a>

    <a class="navbar__link" href="{{ route('videos.index') }}">
        <span class="material-symbols-outlined">smart_display</span> Видео
    </a>

    <a class="navbar__link" href="{{ route('channels.index') }}">
        <span class="material-symbols-outlined">video_library</span> Каналы
    </a>

    <a class="navbar__link" href="{{ route('terms.index') }}">
        <span class="material-symbols-outlined">description</span> Термины
    </a>

    <a class="navbar__link" href="{{ route('photos.index') }}">
        <span class="material-symbols-outlined">photo_camera</span> Фотографии
    </a>
</nav>
