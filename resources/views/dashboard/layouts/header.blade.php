<header class="header">
    <div class="header__inner">
        {{-- Logo --}}
        <div class="header__logo-wrapper">
            <x-global.material-symbol-outlined class="header__leftbar-toggler unselectable" icon="menu" title="Переключить меню" />
            <h4 class="header__logo-text">{{ env('APP_NAME') }}</h4>
        </div>

        {{-- Menu --}}
        <div class="header__menu">
            {{-- Theme toggler --}}
            <form class="theme-toggler-form" action="{{ route('dashboard.settings.toggle.theme') }}" method="POST">
                @csrf
                @method('PATCH')

                <x-global.button
                    style="transparent"
                    class="theme-toggler-form__button"
                    title="Сменить тему"
                    icon="{{ request()->user()->settings['preferred_theme'] == 'light' ? 'dark_mode' : 'light_mode' }}"
                    filled-icon="true">
                </x-global.button>
            </form>

            {{-- Profile dropdown --}}
            <x-dashboard.dropdowns.profile-dropdown />
        </div>
    </div>
</header>
