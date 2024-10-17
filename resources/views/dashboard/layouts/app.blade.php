<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">

    <title>Админка — {{ env('APP_NAME') }}</title>

    <x-global.noindex-tags />

    {{-- All css plugins are included in main.css file --}}
    @vite('resources/css/dashboard/main.css')
</head>

<body class="body {{ $pageName }}">
    @include('dashboard.layouts.leftbar')
    @include('dashboard.layouts.header')

    <main class="main">
        @yield('content')
    </main>

    <x-global.spinner />

    {{-- JQuery --}}
    <script src="{{ asset('plugins/jquery/jquery-3.6.4.min.js') }}"></script>

    {{-- Selectize --}}
    <script src="{{ asset('plugins/selectize/selectize.min.js') }}"></script>
    <script src="{{ asset('plugins/selectize/preserve-on-blur-plugin/preserve-on-blur.js') }}"></script>

    {{-- Simditor v2.3.28 --}}
    <script src="{{ asset('plugins/simditor/module.js') }}"></script>
    <script src="{{ asset('plugins/simditor/hotkeys.js') }}"></script>
    <script src="{{ asset('plugins/simditor/uploader.js') }}"></script>
    <script src="{{ asset('plugins/simditor/simditor.js') }}"></script>

    {{-- JQuery UI. Required for JQuery Nested Sortable plugin --}}
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    {{-- JQuery Nested Sortable --}}
    <script src="{{ asset('plugins/jq-nested-sortable/jq-nested-sortable.js') }}"></script>

    @vite('resources/js/dashboard/main.js')
</body>

</html>
