@extends('auth.layouts.app', ['bodyClass' => 'register', 'title' => 'Регистрация'])

@section('content')
    <a href="{{ route('home') }}" class="logo">
        <img class="logo__image" src="{{ asset('img/main/logo.png') }}" alt="lafeum logo">
    </a>

    <h1 class="title">Регистрация</h1>
    <p class="desc"><a href="{{ route('login') }}">У Вас есть аккаунт?</a></p>

    <form class="form register-form" action="{{ route('register') }}" method="POST">
        @csrf

        <x-form.inputs.default-input
            labelText="Имя, Фамилия"
            inputName="name"
            :isRequired="true"
            autofocus />

        <x-form.inputs.default-input
            labelText="Ваш Email"
            inputName="email"
            type="email"
            :isRequired="true" />

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

        <button class="button submit">Зарегистрироваться</button>
    </form>
@endsection
