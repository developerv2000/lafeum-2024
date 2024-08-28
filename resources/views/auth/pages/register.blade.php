@extends('auth.layouts.app', ['bodyClass' => 'register', 'title' => 'Регистрация'])

@section('content')
    <a href="{{ route('home') }}" class="logo">
        <img class="logo__image" src="{{ asset('img/main/logo.png') }}" alt="lafeum logo">
    </a>

    <h1 class="title">Регистрация</h1>
    <p class="desc"><a href="{{ route('login') }}">У Вас есть аккаунт?</a></p>

    <form class="form register-form" action="{{ route('register') }}" method="POST">
        @csrf

        <x-form.input.default-input
            label="Имя, Фамилия"
            name="name"
            autofocus
            required />

        <x-form.input.default-input
            label="Ваш Email"
            name="email"
            type="email"
            required />

        <x-form.input.default-input
            label="Пароль"
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

        <button class="button submit">Зарегистрироваться</button>
    </form>
@endsection
