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
            <img class="profile-edit__update-ava-image" src="{{ $user->photo_asset_url }}" alt="ava">

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

            <x-form.inputs.record-field-input
                labelText="Имя пользователя"
                field="name"
                :model="$user"
                :isRequired="true" />

            <x-form.inputs.record-field-input
                labelText="Электронная почта"
                field="email"
                :model="$user"
                :isRequired="true" />

            <x-form.inputs.record-field-input
                labelText="День рождения"
                field="birthday"
                type="date"
                :model="$user"
                min="1950-01-01"
                max="2020-01-01"
                :initialValue="$user->birthday?->format('Y-m-d')" />

            <x-form.selects.native.id-based-single-select.record-field-select
                labelText="Пол"
                field="gender_id"
                :model="$user"
                :options="$genders"
                placeholderText="Не выбрано" />

            <x-form.selects.native.id-based-single-select.record-field-select
                labelText="Страна"
                field="country_id"
                :model="$user"
                :options="$countries"
                placeholderText="Не выбрано" />

            <x-form.textareas.record-field-textarea
                labelText="Коротко о себе"
                field="biography"
                :model="$user"
                maxlength="32000" />

            <x-global.button>Обновить</x-global.button>
        </form>
    </div>

    {{-- Password update --}}
    <div class="profile-edit__password-update styled-box" id="password-update">
        <h2 class="secondary-title">Смена пароля</h2>

        <form class="profile-edit__password-update-form form" action="{{ route('password.update') }}" method="POST" data-on-submit="show-spinner">
            @csrf
            @method('PUT')

            <x-form.inputs.default-input
                labelText="Старый пароль"
                inputName="current_password"
                validationErrorKey="updatePassword"
                type="password"
                autocomplete="current-password"
                minlength="4"
                :isRequired="true" />

            <x-form.inputs.default-input
                labelText="Новый пароль"
                inputName="password"
                validationErrorKey="updatePassword"
                type="password"
                autocomplete="new-password"
                minlength="4"
                :isRequired="true" />

            <x-form.inputs.default-input
                labelText="Подтвердите новый пароль"
                inputName="password_confirmation"
                validationErrorKey="updatePassword"
                type="password"
                autocomplete="new-password"
                minlength="4"
                :isRequired="true" />

            <x-global.button>Обновить</x-global.button>
        </form>
    </div>
@endsection
