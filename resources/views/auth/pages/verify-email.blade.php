@extends('auth.layouts.app', ['bodyClass' => 'verify-email-prompt', 'title' => 'Подтвердите почту'])

@section('content')
    <a href="{{ route('home') }}" class="logo">
        <img class="logo__image" src="{{ asset('img/main/logo.png') }}" alt="lafeum logo">
    </a>

    <h1 class="title">Подтвердите почту</h1>

    <p class="desc">
        Спасибо за регистрацию! Прежде чем начать, не могли бы вы подтвердить свой адрес электронной почты, перейдя по ссылке, которую мы только что отправили вам по электронной почте? Если вы не получили электронное письмо, мы с радостью вышлем вам другое.
    </p>

    <form class="form resend-email-verification-form" action="{{ route('verification.send') }}" method="POST">
        @csrf
        <button class="button submit">Выслать повторно</button>
    </form>

    <form class="verify-email-prompt__logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="button verify-email-prompt__logout-button">Выйти из аккаунта</button>
    </form>
@endsection
