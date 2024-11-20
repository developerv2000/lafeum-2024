<x-front.different.leftbar class="account-leftbar" title="Мой аккаунт">
    {{-- Ava box --}}
    <div class="ava-box">
        <img class="ava-box__image" src="{{ $user->photo_asset_url }}" alt="{{ $user->name }}">

        <div class="ava-box__text-wrapper">
            <h3 class="ava-box__name">{{ $user->name }}</h3>
            <p class="ava-box__role">{{ $user->isAdministrator() ? 'Администратор' : 'Пользователь' }}</p>
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
            <x-global.material-symbol-outlined icon="bookmark" filled="1" /> Мои избранные
        </a>

        {{-- Folders --}}
        <div class="accout-leftbar__folders-wrapper">
            {{-- Root folders --}}
            @foreach ($user->rootFolders as $root)
                <a class="leftbar__nav-link @if(request()->routeIs('folders.show') && request()->route('record')->id == $root->id) leftbar__nav-link--active @endif" href="{{ route('folders.show', $root->id) }}">
                    <x-global.material-symbol-outlined icon="folder_open" filled="1" /> {{ $root->name }}
                </a>

                {{-- Child folders --}}
                @if ($root->childs->count())
                    <div class="accout-leftbar__subfolders-wrapper">
                        @foreach ($root->childs as $child)
                            <a class="leftbar__nav-link @if(request()->routeIs('folders.show') && request()->route('record')->id == $child->id) leftbar__nav-link--active @endif" href="{{ route('folders.show', $child->id) }}">
                                <x-global.material-symbol-outlined icon="sort" filled="1" /> {{ $child->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
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
