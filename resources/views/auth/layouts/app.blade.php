<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- blade-formatter-disable-next-line --}}
    <title>@isset($title){{ $title . ' — ЛАФЕЮМ' }}@else{{ 'ЛАФЕЮМ' }}@endisset</title>

    <x-global.noindex-tags />

    @vite('resources/css/front/auth.css')
</head>

<body class="body {{ $bodyClass }}">
    <main class="main">
        <div class="box">
            @yield('content')
        </div>
    </main>

    <x-global.spinner />

    @vite('resources/js/front/auth.js')
</body>

</html>
