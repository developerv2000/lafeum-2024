<aside class="leftbar thin-scrollbar">
    {{-- Main --}}
    <div class="leftbar__section leftbar__section--main">
        <p class="leftbar__section-title">Основные</p>

        <nav class="leftbar__nav">
            {{-- Quotes --}}
            <div class="leftbar__nav-collapse-wrapper">
                <button
                    @class([
                        'collapse-button',
                        'collapse-button--active' => request()->routeIs('dashboard.quotes.*'),
                        'leftbar__collapse-button',
                    ])
                    data-click-action="toggle-collapse"
                    data-collapse-selector=".leftbar__collapse--quotes">

                    <span class="collapse-button__text">Цитаты</span>
                    <span class="material-symbols-outlined collapse-button__icon">arrow_drop_down</span>
                </button>

                <div
                    @class([
                        'collapse',
                        'collapse--open' => request()->routeIs('dashboard.quotes.*'),
                        'leftbar__collapse',
                        'leftbar__collapse--quotes',
                    ])>

                    <a class="leftbar__collapse-link" href="{{ route('dashboard.quotes.index') }}">Все цитаты</a>
                    <a class="leftbar__collapse-link" href="{{ route('dashboard.quotes.trash') }}">Корзина</a>
                </div>
            </div>

            {{-- Terms --}}
            <div class="leftbar__nav-collapse-wrapper">
                <button
                    @class([
                        'collapse-button',
                        'collapse-button--active' => request()->routeIs('dashboard.terms.*'),
                        'leftbar__collapse-button',
                    ])
                    data-click-action="toggle-collapse"
                    data-collapse-selector=".leftbar__collapse--terms">

                    <span class="collapse-button__text">Термины</span>
                    <span class="material-symbols-outlined collapse-button__icon">arrow_drop_down</span>
                </button>

                <div
                    @class([
                        'collapse',
                        'collapse--open' => request()->routeIs('dashboard.terms.*'),
                        'leftbar__collapse',
                        'leftbar__collapse--terms',
                    ])>

                    <a class="leftbar__collapse-link" href="{{ route('dashboard.terms.index') }}">Все термины</a>
                    <a class="leftbar__collapse-link" href="{{ route('dashboard.terms.trash') }}">Корзина</a>
                </div>
            </div>
        </nav>
    </div>
</aside>
