<header class="header">
    <div class="header__inner">
        {{-- Logo --}}
        <div class="header__logo-wrapper">
            <h1 class="header__logo">{{ env('APP_NAME') }}</h1>
        </div>

        {{-- Menu --}}
        <div class="header__menu">
            <x-dashboard.dropdowns.profile-dropdown />
        </div>
    </div>
</header>
