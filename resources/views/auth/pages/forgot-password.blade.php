@extends('auth.layouts.app', ['bodyClass' => 'forgot-password', 'title' => 'Восстановление пароля'])

@section('content')
    <a href="{{ route('home') }}" class="logo">
        <img class="logo__image" src="{{ asset('img/main/logo.png') }}" alt="lafeum logo">
    </a>

    <h1 class="title">Восстановление пароля</h1>

    <p class="desc">
        @session('status')
            <strong>{{ $value }}</strong> <br><br>
        @endsession

        Забыли пароль? Без проблем. Просто сообщите нам свой адрес электронной почты, и мы отправим вам ссылку для сброса пароля, которая позволит вам выбрать новый.
    </p>

    <form class="form forgot-password-form" action="{{ route('password.email') }}" method="POST">
        @csrf

        <x-form.inputs.default-input
            labelText="Ваш Email"
            inputName="email"
            type="email"
            :isRequired="true"
            autofocus />

        <button class="button submit">Запросить ссылку</button>
    </form>
@endsection
