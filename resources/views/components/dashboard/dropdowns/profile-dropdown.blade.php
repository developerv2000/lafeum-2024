<x-global.dropdown id="profile-dropdown" class="profile-dropdown" button-style="transparent">
    <x-slot:button>
        <img class="profile-dropdown__ava" src="{{ auth()->user()->photo_asset_path }}" alt="ava">
    </x-slot:button>

    <x-slot:content>
        <a class="profile-dropdown__link" href="{{ route('profile.edit') }}">
            <x-global.material-symbol-outlined icon="account_circle" filled="true" />
            Мой профиль
        </a>

        <a class="profile-dropdown__link" href="{{ route('likes.index') }}">
            <x-global.material-symbol-outlined icon="language" />
            Перейти на сайт
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
