@extends('auth.layouts.app', ['bodyClass' => 'login', 'title' => 'Вход'])

@section('content')
    <a href="{{ route('home') }}" class="logo">
        <img class="logo__image" src="{{ asset('img/main/logo.png') }}" alt="lafeum logo">
    </a>

    <h1 class="title">Вход</h1>
    <p class="desc">Добро пожаловать, мы ждали Вас !</p>

    <form class="form login-form" action="/login" method="POST">
        @csrf

        <x-form.input.default-input label="Ваш Email" name="email" type="email" autofocus required />
        <x-form.input.default-input label="Пароль" name="password" type="password" autocomplete="current-password" minlength="4" required />

        <div class="login__links-wrapper">
            <a class="login-link" href="{{ route('register') }}">У вас нет аккаунта?</a>
            <a class="login-link" href="{{ route('password.request') }}">Забыли пароль?</a>
        </div>

        <button class="button submit">Войти</button>
    </form>
@endsection
