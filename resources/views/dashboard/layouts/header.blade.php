<header class="header">
    <div class="header__inner">
        {{-- Logo --}}
        <div class="header__logo">
            <x-global.material-symbol-outlined class="header__logo-icon" icon="dashboard" filled="true" />
            <h1 class="header__logo-text">{{ env('APP_NAME') }}</h1>
        </div>

        {{-- Menu --}}
        <div class="header__menu">
            <x-dashboard.dropdowns.profile-dropdown />
        </div>
    </div>
</header>
