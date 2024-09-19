<x-front.different.leftbar class="account-leftbar" title="Мой аккаунт">
    {{-- Ava box --}}
    <div class="ava-box">
        <img class="ava-box__image" src="{{ $user->photo_asset_path }}" alt="{{ $user->name }}">

        <div class="ava-box__text-wrapper">
            <h3 class="ava-box__name">{{ $user->name }}</h3>
            <p class="ava-box__role">{{ $user->isAdmin() ? 'Администратор' : 'Пользователь' }}</p>
        </div>
    </div>

    {{-- Divider --}}
    <hr class="leftbar__body-divider">

    {{-- Navbar --}}
    <nav class="leftbar__nav">
        <a @class([
            'leftbar__nav-link',
            'leftbar__nav-link--active' => request()->routeIs('profile.edit'),
        ]) href="{{ route('profile.edit') }}">
            <x-global.material-symbol-outlined icon="account_circle" filled="1" /> Мой профиль
        </a>

        <a @class([
            'leftbar__nav-link',
            'leftbar__nav-link--active' => request()->routeIs('likes.index'),
        ]) href="{{ route('likes.index') }}">
            <x-global.material-symbol-outlined icon="favorite" filled="1" /> Мои лайки
        </a>

        <a @class([
            'leftbar__nav-link',
            'leftbar__nav-link--active' => request()->routeIs('favorites.index'),
        ]) href="{{ route('favorites.index') }}">
            <x-global.material-symbol-outlined icon="folder_open" filled="1" /> Мои избранные
        </a>
    </nav>

    {{-- Divider --}}
    <hr class="leftbar__body-divider">

    {{-- Logout form --}}
    <form class="accout-leftbar__logout" action="{{ route('logout') }}" method="POST">
        @csrf

        <button class="accout-leftbar__logout-submit">
            <x-global.material-symbol-outlined icon="logout" filled="true" />
            Выход
        </button>
    </form>
</x-front.different.leftbar>
