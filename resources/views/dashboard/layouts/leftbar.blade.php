<aside
    @class([
        'leftbar',
        'leftbar--collapsed' => auth()->user()->settings[
            'collapsed_dashboard_leftbar'
        ],
    ])>
    <div class="leftbar__inner thin-scrollbar">
        {{-- Main --}}
        <div class="leftbar__section leftbar__section--main">
            <p class="leftbar__section-title">Основное</p>

            <nav class="leftbar__nav">
                {{-- Quotes --}}
                <div class="leftbar__collapse-wrapper">
                    <button
                        @class([
                            'collapse-button',
                            'collapse-button--active' => request()->routeIs('dashboard.quotes.*'),
                            'leftbar__collapse-button',
                        ])
                        data-click-action="toggle-collapse"
                        data-collapse-selector=".leftbar__collapse--quotes">

                        <x-global.material-symbol-outlined class="collapse-button__decorative-icon" icon="format_quote" />
                        <span class="collapse-button__text">Цитаты</span>
                        <x-global.material-symbol-outlined class="collapse-button__icon" icon="arrow_drop_down" />
                    </button>

                    <div
                        @class([
                            'collapse',
                            'collapse--open' => request()->routeIs('dashboard.quotes.*'),
                            'leftbar__collapse',
                            'leftbar__collapse--quotes',
                        ])>

                        <a
                            @class([
                                'leftbar__collapse-link',
                                'leftbar__collapse-link--active' => request()->routeIs(
                                    'dashboard.quotes.index'),
                            ])
                            href="{{ route('dashboard.quotes.index') }}">Все цитаты
                        </a>

                        <a
                            @class([
                                'leftbar__collapse-link',
                                'leftbar__collapse-link--active' => request()->routeIs(
                                    'dashboard.quotes.trash'),
                            ])
                            href="{{ route('dashboard.quotes.trash') }}">Корзина
                        </a>
                    </div>
                </div>

                {{-- Terms --}}
                <div class="leftbar__collapse-wrapper">
                    <button
                        @class([
                            'collapse-button',
                            'collapse-button--active' => request()->routeIs('dashboard.terms.*'),
                            'leftbar__collapse-button',
                        ])
                        data-click-action="toggle-collapse"
                        data-collapse-selector=".leftbar__collapse--terms">

                        <x-global.material-symbol-outlined class="collapse-button__decorative-icon" icon="notes" />
                        <span class="collapse-button__text">Термины</span>
                        <x-global.material-symbol-outlined class="collapse-button__icon" icon="arrow_drop_down" />
                    </button>

                    <div
                        @class([
                            'collapse',
                            'collapse--open' => request()->routeIs('dashboard.terms.*'),
                            'leftbar__collapse',
                            'leftbar__collapse--terms',
                        ])>

                        <a
                            @class([
                                'leftbar__collapse-link',
                                'leftbar__collapse-link--active' => request()->routeIs(
                                    'dashboard.terms.index'),
                            ])
                            href="{{ route('dashboard.terms.index') }}">Все термины
                        </a>

                        <a
                            @class([
                                'leftbar__collapse-link',
                                'leftbar__collapse-link--active' => request()->routeIs(
                                    'dashboard.terms.trash'),
                            ])
                            href="{{ route('dashboard.terms.trash') }}">Корзина
                        </a>
                    </div>
                </div>

                {{-- Videos --}}
                <div class="leftbar__collapse-wrapper">
                    <button
                        @class([
                            'collapse-button',
                            'collapse-button--active' => request()->routeIs('dashboard.videos.*'),
                            'leftbar__collapse-button',
                        ])
                        data-click-action="toggle-collapse"
                        data-collapse-selector=".leftbar__collapse--videos">

                        <x-global.material-symbol-outlined class="collapse-button__decorative-icon" icon="smart_display" />
                        <span class="collapse-button__text">Видео</span>
                        <x-global.material-symbol-outlined class="collapse-button__icon" icon="arrow_drop_down" />
                    </button>

                    <div
                        @class([
                            'collapse',
                            'collapse--open' => request()->routeIs('dashboard.videos.*'),
                            'leftbar__collapse',
                            'leftbar__collapse--videos',
                        ])>

                        <a
                            @class([
                                'leftbar__collapse-link',
                                'leftbar__collapse-link--active' => request()->routeIs(
                                    'dashboard.videos.index'),
                            ])
                            href="{{ route('dashboard.videos.index') }}">Все видео
                        </a>

                        <a
                            @class([
                                'leftbar__collapse-link',
                                'leftbar__collapse-link--active' => request()->routeIs(
                                    'dashboard.videos.trash'),
                            ])
                            href="{{ route('dashboard.videos.trash') }}">Корзина
                        </a>
                    </div>
                </div>

                {{-- Photos --}}
                <div class="leftbar__collapse-wrapper">
                    <button
                        @class([
                            'collapse-button',
                            'collapse-button--active' => request()->routeIs('dashboard.photos.*'),
                            'leftbar__collapse-button',
                        ])
                        data-click-action="toggle-collapse"
                        data-collapse-selector=".leftbar__collapse--photos">

                        <x-global.material-symbol-outlined class="collapse-button__decorative-icon" icon="image" />
                        <span class="collapse-button__text">Фото</span>
                        <x-global.material-symbol-outlined class="collapse-button__icon" icon="arrow_drop_down" />
                    </button>

                    <div
                        @class([
                            'collapse',
                            'collapse--open' => request()->routeIs('dashboard.photos.*'),
                            'leftbar__collapse',
                            'leftbar__collapse--photos',
                        ])>

                        <a
                            @class([
                                'leftbar__collapse-link',
                                'leftbar__collapse-link--active' => request()->routeIs(
                                    'dashboard.photos.index'),
                            ])
                            href="{{ route('dashboard.photos.index') }}">Все фото
                        </a>

                        <a
                            @class([
                                'leftbar__collapse-link',
                                'leftbar__collapse-link--active' => request()->routeIs(
                                    'dashboard.photos.trash'),
                            ])
                            href="{{ route('dashboard.photos.trash') }}">Корзина
                        </a>
                    </div>
                </div>

                {{-- Authors --}}
                <div class="leftbar__collapse-wrapper">
                    <button
                        @class([
                            'collapse-button',
                            'collapse-button--active' => request()->routeIs('dashboard.authors.*'),
                            'leftbar__collapse-button',
                        ])
                        data-click-action="toggle-collapse"
                        data-collapse-selector=".leftbar__collapse--authors">

                        <x-global.material-symbol-outlined class="collapse-button__decorative-icon" icon="account_circle" />
                        <span class="collapse-button__text">Авторы</span>
                        <x-global.material-symbol-outlined class="collapse-button__icon" icon="arrow_drop_down" />
                    </button>

                    <div
                        @class([
                            'collapse',
                            'collapse--open' => request()->routeIs('dashboard.authors.*'),
                            'leftbar__collapse',
                            'leftbar__collapse--authors',
                        ])>

                        <a
                            @class([
                                'leftbar__collapse-link',
                                'leftbar__collapse-link--active' => request()->routeIs(
                                    'dashboard.authors.index'),
                            ])
                            href="{{ route('dashboard.authors.index') }}">Все авторы
                        </a>

                        <a
                            @class([
                                'leftbar__collapse-link',
                                'leftbar__collapse-link--active' => request()->routeIs(
                                    'dashboard.authors.trash'),
                            ])
                            href="{{ route('dashboard.authors.trash') }}">Корзина
                        </a>
                    </div>
                </div>

                {{-- Channels --}}
                <div class="leftbar__collapse-wrapper">
                    <button
                        @class([
                            'collapse-button',
                            'collapse-button--active' => request()->routeIs('dashboard.channels.*'),
                            'leftbar__collapse-button',
                        ])
                        data-click-action="toggle-collapse"
                        data-collapse-selector=".leftbar__collapse--channels">

                        <x-global.material-symbol-outlined class="collapse-button__decorative-icon" icon="video_library" />
                        <span class="collapse-button__text">Каналы</span>
                        <x-global.material-symbol-outlined class="collapse-button__icon" icon="arrow_drop_down" />
                    </button>

                    <div
                        @class([
                            'collapse',
                            'collapse--open' => request()->routeIs('dashboard.channels.*'),
                            'leftbar__collapse',
                            'leftbar__collapse--channels',
                        ])>

                        <a
                            @class([
                                'leftbar__collapse-link',
                                'leftbar__collapse-link--active' => request()->routeIs(
                                    'dashboard.channels.index'),
                            ])
                            href="{{ route('dashboard.channels.index') }}">Все каналы
                        </a>

                        <a
                            @class([
                                'leftbar__collapse-link',
                                'leftbar__collapse-link--active' => request()->routeIs(
                                    'dashboard.channels.trash'),
                            ])
                            href="{{ route('dashboard.channels.trash') }}">Корзина
                        </a>
                    </div>
                </div>

                {{-- Categories --}}
                <div class="leftbar__collapse-wrapper">
                    <button
                        @class([
                            'collapse-button',
                            'collapse-button--active' => request()->routeIs('dashboard.categories.*'),
                            'leftbar__collapse-button',
                        ])
                        data-click-action="toggle-collapse"
                        data-collapse-selector=".leftbar__collapse--categories">

                        <x-global.material-symbol-outlined class="collapse-button__decorative-icon" icon="category" />
                        <span class="collapse-button__text">Категории</span>
                        <x-global.material-symbol-outlined class="collapse-button__icon" icon="arrow_drop_down" />
                    </button>

                    <div
                        @class([
                            'collapse',
                            'collapse--open' => request()->routeIs('dashboard.categories.*'),
                            'leftbar__collapse',
                            'leftbar__collapse--categories',
                        ])>

                        <a
                            @class([
                                'leftbar__collapse-link',
                                'leftbar__collapse-link--active' =>
                                    request()->routeIs('dashboard.categories.index') &&
                                    request()->route('model') == 'Knowledge',
                            ])
                            href="{{ route('dashboard.categories.index', ['model' => 'Knowledge']) }}">Область знаний
                        </a>

                        <a
                            @class([
                                'leftbar__collapse-link',
                                'leftbar__collapse-link--active' =>
                                    request()->routeIs('dashboard.categories.index') &&
                                    request()->route('model') == 'QuoteCategory',
                            ])
                            href="{{ route('dashboard.categories.index', ['model' => 'QuoteCategory']) }}">Цитаты
                        </a>

                        <a
                            @class([
                                'leftbar__collapse-link',
                                'leftbar__collapse-link--active' =>
                                    request()->routeIs('dashboard.categories.index') &&
                                    request()->route('model') == 'TermCategory',
                            ])
                            href="{{ route('dashboard.categories.index', ['model' => 'TermCategory']) }}">Термины
                        </a>

                        <a
                            @class([
                                'leftbar__collapse-link',
                                'leftbar__collapse-link--active' =>
                                    request()->routeIs('dashboard.categories.index') &&
                                    request()->route('model') == 'VideoCategory',
                            ])
                            href="{{ route('dashboard.categories.index', ['model' => 'VideoCategory']) }}">Видео
                        </a>
                    </div>
                </div>

                {{-- Users --}}
                <a class="leftbar__nav-link" href="{{ route('dashboard.users.index') }}">
                    <x-global.material-symbol-outlined class="leftbar__nav-link-icon" icon="group" />
                    <span class="leftbar__nav-link-text">Пользователи</span>
                </a>

                {{-- Feedback --}}
                <a class="leftbar__nav-link" href="{{ route('dashboard.feedbacks.index') }}">
                    <x-global.material-symbol-outlined class="leftbar__nav-link-icon" icon="forum" />
                    <span class="leftbar__nav-link-text">Обратная связь</span>
                </a>
            </nav>
        </div> {{-- End main --}}

        {{-- Additional --}}
        <div class="leftbar__section leftbar__section--main">
            <p class="leftbar__section-title">Дополнительно</p>

            <nav class="leftbar__nav">
                <a class="leftbar__nav-link" href="{{ route('home') }}" target="_blank">
                    <x-global.material-symbol-outlined class="leftbar__nav-link-icon" icon="language" />
                    <span class="leftbar__nav-link-text">Перейти на сайт</span>
                </a>

                <form class="leftbar__nav-form" action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button class="leftbar__nav-form-button">
                        <x-global.material-symbol-outlined icon="logout" />
                        <span class="leftbar__nav-form-text">Выход</span>
                    </button>
                </form>
            </nav>
        </div> {{-- End additional --}}
    </div>
</aside>
