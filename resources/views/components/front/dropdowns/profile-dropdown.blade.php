<x-global.dropdown class="profile-dropdown" include-arrow="true">
    <x-slot:button>
        <img class="profile-dropdown__ava" src="{{ auth()->user()->photo_path }}" alt="ava">
    </x-slot:button>

    <x-slot:content>
        <a class="profile-dropdown__link" href="{{ route('home') }}">
            <x-global.material-symbol-outlined icon="account_circle" filled="true" />
            Мой профиль
        </a>

        <a class="profile-dropdown__link" href="{{ route('home') }}">
            <x-global.material-symbol-outlined icon="favorite" />
            Лайки
        </a>

        <a class="profile-dropdown__link" href="{{ route('home') }}">
            <x-global.material-symbol-outlined icon="folder_open" filled="true" />
            Избранное
        </a>

        <form class="profile-dropdown__form" action="{{ route('logout') }}" method="POST">
            @csrf

            <button class="profile-dropdown__button">
                <x-global.material-symbol-outlined icon="logout" filled="true" />
                Выход
            </button>
        </form>
    </x-slot:content>
</x-global.dropdown>
