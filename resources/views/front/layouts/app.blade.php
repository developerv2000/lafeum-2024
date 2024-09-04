<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- blade-formatter-disable-next-line --}}
    <title>@isset($title){{ $title . ' — ЛАФЕЮМ' }}@else{{ 'ЛАФЕЮМ' }}@endisset</title>

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

    <x-front.different.scroll-buttons />
    <x-global.spinner />

    @vite('resources/js/front/main.js')
</body>

</html>
