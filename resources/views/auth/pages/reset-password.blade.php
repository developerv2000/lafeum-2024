@extends('auth.layouts.app', ['bodyClass' => 'reset-password', 'title' => 'Сбросить пароль'])

@section('content')
    <a href="{{ route('home') }}" class="logo">
        <img class="logo__image" src="{{ asset('img/main/logo.png') }}" alt="lafeum logo">
    </a>

    <h1 class="title">Сбросить пароль</h1>

    <form class="form reset-password-form" action="{{ route('password.store') }}" method="POST">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <x-form.input.request-based-input
            label="Ваш Email"
            name="email"
            type="email"
            autocomplete="username"
            autofocus
            required />

        <x-form.input.default-input
            label="Новый пароль"
            name="password"
            type="password"
            autocomplete="new-password"
            minlength="4"
            required />

        <x-form.input.default-input
            label="Подтверждения пароля"
            name="password_confirmation"
            type="password"
            autocomplete="new-password"
            minlength="4"
            required />

        <button class="button submit">Обновить пароль</button>
    </form>
@endsection
