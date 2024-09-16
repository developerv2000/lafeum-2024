@extends('front.layouts.app', [
    'bodyClass' => 'profile-edit',
    'includeRightbar' => false,
])

@section('content')
    {{-- Personal data --}}
    <div class="profile-edit__personal-data styled-box">
        <h1 class="profile-edit__form-title main-title">Личные данные</h1>

        <form class="profile-edit__form form" action="{{ route('profile.edit') }}" method="POST">
            @csrf

            <x-form.input.record-edit-input
                label="Имя пользователя"
                name="name"
                :record="$record"
                required />

            <x-form.input.record-edit-input
                label="Электронная почта"
                name="email"
                :record="$record"
                required />

            <x-form.input.record-edit-input
                label="День рождения"
                name="birthday"
                type="date"
                :record="$record"
                required />
        </form>
    </div>

    {{-- Password update --}}
    <div class="profile-edit__password-update styled-box">
        <h2 class="profile-edit__form-title main-title">Смена пароля</h2>

        <form class="profile-edit__form form" action="{{ route('password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.input.default-input
                label="Старый пароль"
                name="current_password"
                bagged-error-name="updatePassword"
                type="password"
                autocomplete="current-password"
                minlength="4"
                required />

            <x-form.input.default-input
                label="Новый пароль"
                name="password"
                bagged-error-name="updatePassword"
                type="password"
                autocomplete="new-password"
                minlength="4"
                required />

            <x-form.input.default-input
                label="Подтвердите новый пароль"
                name="password_confirmation"
                bagged-error-name="updatePassword"
                type="password"
                autocomplete="new-password"
                minlength="4"
                required />

            <x-global.button>Обновить</x-global.button>
        </form>
    </div>
@endsection
