@extends('auth.layouts.app', ['bodyClass' => 'login', 'title' => 'Вход'])

@section('content')
    <a href="{{ route('home') }}" class="logo">
        <img class="logo__image" src="{{ asset('img/main/logo.png') }}" alt="lafeum logo">
    </a>

    <h1 class="title">Вход</h1>
    <p class="desc">Добро пожаловать, мы ждали Вас !</p>

    <form class="form login-form form--with-recaptcha" action="{{ route('login') }}" method="POST">
        @csrf

        {{-- reCAPTCHA v3 Token. Set automatically on form submit --}}
        <input type="hidden" name="recaptcha_token" id="recaptcha_token">

        <x-form.inputs.default-input
            labelText="Ваш Email"
            inputName="email"
            type="email"
            :isRequired="true"
            autofocus />

        <x-form.inputs.default-input
            labelText="Пароль"
            inputName="password"
            type="password"
            autocomplete="current-password"
            minlength="4"
            :isRequired="true" />

        <div class="login__links-wrapper">
            <a class="login-link" href="{{ route('register') }}">У вас нет аккаунта?</a>
            <a class="login-link" href="{{ route('password.request') }}">Забыли пароль?</a>
        </div>

        <button class="button submit">Войти</button>
    </form>
@endsection
