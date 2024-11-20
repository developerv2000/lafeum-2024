@extends('auth.layouts.app', ['bodyClass' => 'reset-password', 'title' => 'Сбросить пароль'])

@section('content')
    <a href="{{ route('home') }}" class="logo">
        <img class="logo__image" src="{{ asset('img/main/logo.png') }}" alt="lafeum logo">
    </a>

    <h1 class="title">Сбросить пароль</h1>

    <form class="form reset-password-form" action="{{ route('password.store') }}" method="POST">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <x-form.inputs.request-based-input
            labelText="Ваш Email"
            inputName="email"
            type="email"
            autocomplete="username"
            :isRequired="true"
            autofocus />

        <x-form.inputs.default-input
            labelText="Новый пароль"
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

        <button class="button submit">Обновить пароль</button>
    </form>
@endsection
