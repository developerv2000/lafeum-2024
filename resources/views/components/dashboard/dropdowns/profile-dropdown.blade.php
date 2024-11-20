<x-global.dropdown id="profile-dropdown" class="profile-dropdown" button-style="transparent">
    <x-slot:button>
        <img class="profile-dropdown__ava" src="{{ auth()->user()->photo_asset_url }}" alt="ava">
    </x-slot:button>

    <x-slot:content>
        <a class="dropdown__content-link" href="{{ route('profile.edit') }}">
            <x-global.material-symbol-outlined icon="account_circle" filled="true" />
            Мой профиль
        </a>

        <a class="dropdown__content-link" href="{{ route('home') }}">
            <x-global.material-symbol-outlined icon="language" />
            Перейти на сайт
        </a>

        <form class="dropdown__content-form" action="{{ route('logout') }}" method="POST">
            @csrf

            <button class="dropdown__content-button">
                <x-global.material-symbol-outlined icon="logout" filled="true" />
                Выход
            </button>
        </form>
    </x-slot:content>
</x-global.dropdown>
