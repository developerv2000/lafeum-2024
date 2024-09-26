@extends('front.layouts.app', [
    'bodyClass' => 'profile-edit',
    'includeRightbar' => false,
    'noindex' => true,
    'title' => 'Мой профиль',
])

@section('leftbar')
    @include('front.leftbars.account')
@endsection

@section('content')
    <h1 class="profile-edit__title main-title">Мой профиль</h1>

    {{-- Ava --}}
    <div class="profile-edit__update-ava styled-box">
        <h2 class="secondary-title">Фото профиля</h2>

        <div class="profile-edit__update-ava-row">
            <img class="profile-edit__update-ava-image" src="{{ $user->photo_asset_path }}" alt="ava">

            {{-- Update Ava --}}
            <form class="update-ava-form" action="{{ route('profile.update.ava') }}" method="POST" enctype="multipart/form-data" data-on-submit="show-spinner">
                @csrf
                @method('PATCH')

                <label class="update-ava-form__label button button--main">
                    <input class="update-ava-form__input visually-hidden" type="file" name="photo" accept=".png, .jpg, .jpeg" required>
                    <span class="update-ava-form__span">Изменить</span>
                </label>
            </form>

            {{-- Delete Ava --}}
            @if ($user->photo)
                <form class="delete-ava-form" action="{{ route('profile.delete.ava') }}" method="POST" data-on-submit="show-spinner">
                    @csrf
                    @method('PATCH')
                    <x-global.button style="cancel">Удалить</x-global.button>
                </form>
            @endif
        </div>
    </div>

    {{-- Personal data --}}
    <div class="profile-edit__personal-data styled-box">
        <h2 class="secondary-title">Личные данные</h2>

        <form class="profile-edit__personal-data-form form" action="{{ route('profile.update') }}" method="POST" data-on-submit="show-spinner">
            @csrf
            @method('PATCH')

            <x-form.input.record-edit-input
                label="Имя пользователя"
                name="name"
                :record="$user"
                required />

            <x-form.input.record-edit-input
                label="Электронная почта"
                name="email"
                :record="$user"
                required />

            <x-form.input.record-edit-input
                label="День рождения"
                name="birthday"
                type="date"
                :record="$user" />

            <x-form.select.native.id-based-single-select.record-edit-select
                label="Пол"
                name="gender_id"
                :record="$user"
                :options="$genders"
                placeholder="Не выбрано" />

            <x-form.select.native.id-based-single-select.record-edit-select
                label="Страна"
                name="country_id"
                :record="$user"
                :options="$countries"
                placeholder="Не выбрано" />

            <x-form.textarea.record-edit-textarea
                label="Коротко о себе"
                name="biography"
                :record="$user" />

            <x-global.button>Обновить</x-global.button>
        </form>
    </div>

    {{-- Password update --}}
    <div class="profile-edit__password-update styled-box" id="password-update">
        <h2 class="secondary-title">Смена пароля</h2>

        <form class="profile-edit__password-update-form form" action="{{ route('password.update') }}" method="POST" data-on-submit="show-spinner">
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
