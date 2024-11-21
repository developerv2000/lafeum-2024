@extends('dashboard.layouts.app', [
    'pageName' => 'users-edit',
    'mainAutoOverflowed' => false,
])

@section('content')
    <div class="toolbar">
        {{-- blade-formatter-disable --}}
        @php
            $crumbs = [
                ['link' => route('dashboard.users.index'), 'text' => 'Все пользователи'],
                ['link' => null, 'text' => 'Редактировать'],
                ['link' => null, 'text' => '#' . $record->id],
            ];
        @endphp
        {{-- blade-formatter-enable --}}

        <x-dashboard.layouts.breadcrumbs :crumbs="$crumbs" />
    </div>

    <x-dashboard.form-templates.edit-template
        :action="route('dashboard.users.update.password', $record->id)"
        submitText="Обновить пароль"
        submitIcon="lock_reset">

        <div class="form__block">
            <h2 class="main-title main-title--marginless">Обновить пароль</h2>

            <div class="form__row">
                <x-form.inputs.default-input
                    labelText="Пароль"
                    inputName="password"
                    type="password"
                    autocomplete="new-password"
                    minlength="4"
                    :isRequired="true" />

                <x-form.inputs.default-input
                    labelText="Подтверждения пароля"
                    inputName="password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    minlength="4"
                    :isRequired="true" />
            </div>
        </div>
    </x-dashboard.form-templates.edit-template>

    @if ($record->isInactive())
        <x-dashboard.form-templates.edit-template
            :action="route('dashboard.users.toggle.inactive-role', $record->id)"
            submitText="Разблокировать"
            submitIcon="lock_open_right">

            <div class="form__block">
                <h2 class="main-title main-title--marginless">Разблокировать пользователья</h2>

                <p>Текущий пользователь заблокирован. Он не может входить на сайт!</p>
            </div>
        </x-dashboard.form-templates.edit-template>
    @else
        <x-dashboard.form-templates.edit-template
            :action="route('dashboard.users.toggle.inactive-role', $record->id)"
            submitText="Заблокировать"
            submitIcon="block">

            <div class="form__block">
                <h2 class="main-title main-title--marginless">Заблокировать пользователья</h2>

                <p>Текущий пользователь не заблокирован. Он может входить на сайт.</p>
            </div>
        </x-dashboard.form-templates.edit-template>
    @endif
@endsection
