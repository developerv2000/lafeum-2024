<header class="header">
    <div class="header__inner">
        <a class="header__logo logo" href="{{ route('home') }}">
            <img class="logo__image" src="{{ asset('img/main/logo-light-ru.png') }}" alt="Лафеюм лого">
        </a>

        {{-- Only tablet & mobile --}}
        <x-global.material-symbol-outlined class="menu-viewer" icon="menu" data-click-action="toggle-mobile-menu" />
        <x-front.different.mobile-menu />

        <x-front.different.navbar class="header__navbar" />

        @guest
            <a class="header__login-btn" href="{{ route('login') }}">Вход</a>
        @else
            <x-front.dropdowns.profile-dropdown />
        @endguest
    </div>
</header>
