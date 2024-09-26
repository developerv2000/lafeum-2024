<footer class="footer">
    <div class="footer__inner">
        <a class="footer__logo logo" href="{{ route('home') }}">
            <img class="logo__image" src="{{ asset('img/main/logo-light-en.png') }}" alt="Lafeum logo">
        </a>

        <nav class="footer__nav">
            <a class="footer__nav-link" href="{{ route('about.us') }}">О сайте</a>
            <a class="footer__nav-link" href="{{ route('contacts') }}">Контакты</a>
            <a class="footer__nav-link" href="{{ route('privacy.policy') }}">Политика конфиденциальности</a>
            <a class="footer__nav-link" href="{{ route('terms.of.use') }}">Пользовательское соглашение</a>
        </nav>

        <p class="footer__copyright">© 2017 - {{ date('Y') }} — Lafeum. Все права защищены.</p>

        <nav class="footer__socials">
            <a class="footer__socials-link" href="https://vk.com/club209177677" target="_blank">
                <img class="footer__socials-image" src="{{ asset('img/main/vk.svg') }}" alt="vkontakte">
            </a>

            <a class="footer__socials-link" href="https://t.me/lafeum_ru" target="_blank">
                <img class="footer__socials-image" src="{{ asset('img/main/telegram.svg') }}" alt="telegram">
            </a>
        </nav>
    </div>
</footer>
