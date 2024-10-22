<header class="header">
    <div class="header__inner">
        {{-- Logo --}}
        <div class="header__logo-wrapper">
            <x-global.material-symbol-outlined class="header__body-width-toggler" icon="hide" title="Изменить максимальную ширину" />
            <h4 class="header__logo">{{ env('APP_NAME') }}</h4>
        </div>

        {{-- Menu --}}
        <div class="header__menu">
            <x-dashboard.dropdowns.profile-dropdown />
        </div>
    </div>
</header>
