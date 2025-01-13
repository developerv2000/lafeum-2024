<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    {{-- blade-formatter-disable-next-line --}}
    <title>@isset($title){{ $title . ' — ЛАФЕЮМ' }}@else{{ 'ЛАФЕЮМ' }}@endisset</title>

    {{-- Noindex on non-production --}}
    @unless (app()->environment('production'))
        <x-global.noindex-tags />
    @endunless

    {{-- Noindex tags --}}
    @if (isset($noindex) && $noindex)
        <x-global.noindex-tags />
    @endif

    <meta property="og:site_name" content="ЛАФЕЮМ">
    <meta property="og:type" content="object">
    <meta name="twitter:card" content="summary_large_image">

    @hasSection('meta-tags')
        @yield('meta-tags')
    @else
        <meta name="description" content="Информированность о методах развития личности и совершенствования профессиональных знаний, осведомленность в вопросах бытия и научно-популярных тем вместе взятых..">
        <meta property="og:title" content="ЛАФЕЮМ">
        <meta property="og:description" content="Информированность о методах развития личности и совершенствования профессиональных знаний, осведомленность в вопросах бытия и научно-популярных тем вместе взятых..">
        <meta property="og:image" content="{{ asset('img/main/share-logo.png') }}">
        <meta property="og:image:alt" content="ЛАФЕЮМ logo">
    @endif

    @vite('resources/css/front/main.css')
</head>

<body class="body {{ $bodyClass }}">
    @include('front.layouts.header')

    <div class="main-wrapper">
        @hasSection('leftbar')
            @yield('leftbar')
        @endif

        <main class="main">
            @yield('content')
        </main>

        @includeWhen($includeRightbar, 'front.layouts.rightbar')
    </div>

    @include('front.layouts.footer')

    <x-front.modals.youtube-videos />
    <x-front.modals.photos />
    <x-front.modals.rename-folder />
    <x-front.modals.destroy-folder />

    <x-front.different.scroll-buttons />
    <x-global.spinner />

    {{-- Google recaptcha v3 --}}
    @if (request()->routeIs('contacts'))
        <script src="https://www.google.com/recaptcha/api.js?render=6LeTtHcpAAAAANDcYSO5J8Kbpd6tYjERQ4-vocAG"></script>
    @endif

    @vite('resources/js/front/main.js')
</body>

</html>
