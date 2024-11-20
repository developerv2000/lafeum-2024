@extends('front.layouts.app', [
    'bodyClass' => 'contacts',
    'includeRightbar' => false,
    'title' => 'Контакты',
])

@section('content')
    <div class="contacts__row">
        {{-- Leftside --}}
        <div class="contacts__leftside">
            <h1 class="contacts__title main-title">Контакты</h1>
            <p class="contacts__desc">
                Мы рады, что Вы посетили наш сайт и ознакомились с находящейся на нем информацией. Вся информация
                находится в свободном доступе и предназначена только для частного пользования. Если Вы считаете, что
                Ваша работа была размещена на нашем сайте в нарушение Вашего авторского права, сообщите нам об этом,
                используя обратную связь. Будем рады рассмотреть Ваши рекомендации по усовершенствованию сайта.
            </p>

            <div class="contacts__email">
                <h4 class="contacts__email-title">Электронная почта:</h4>
                <p class="contacts__email-text">
                    <a class="contacts__email-link" href="mailto:info@lafeum.ru">info@lafeum.ru</a>
                </p>
            </div>
        </div>

        {{-- Feedback --}}
        <div class="feedback">
            <h2 class="feedback__title main-title">Свяжитесь с нами</h2>

            <form class="feedback-form form" action="{{ route('feedbacks.store') }}" method="POST" data-on-submit="show-spinner">
                @csrf

                {{-- reCAPTCHA v3 Token. Set automatically on form submit --}}
                <input type="hidden" name="recaptcha_token" id="recaptcha_token">

                <x-form.inputs.default-input
                    labelText="Ваше имя"
                    inputName="name"
                    :isRequired="true" />

                <x-form.inputs.default-input
                    labelText="Ваш Email"
                    inputName="email"
                    type="email"
                    :isRequired="true" />

                <x-form.inputs.default-input
                    labelText="Тема"
                    inputName="theme" />

                <x-form.textareas.default-textarea
                    labelText="Текст"
                    inputName="message"
                    :isRequired="true" />

                <x-global.button class="feedback-form__submit">Отправить</x-global.button>
            </form>
        </div>
    </div>
@endsection
