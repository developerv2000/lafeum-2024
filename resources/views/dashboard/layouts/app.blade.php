<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <title>Админка — {{ env('APP_NAME') }}</title>

    {{-- Noindex tags --}}
    <x-global.noindex-tags />

    {{-- All css plugins are included inside main.css --}}
    @vite('resources/css/dashboard/main.css')

    {{-- Users prefered theme --}}
    @vite('resources/css/dashboard/themes/' . request()->user()->settings['preferred_theme'] . '.css')
</head>

<body class="body {{ $pageName }}">
    <div class="body__inner">
        @include('dashboard.layouts.header')

        <div class="main-wrapper">
            @include('dashboard.layouts.leftbar')

            <main class="main">
                @yield('content')
            </main>

            @hasSection('rightbar')
                @yield('rightbar')
            @endif
        </div>
    </div>

    {{-- Spinner --}}
    <x-global.spinner />

    {{-- JQuery --}}
    <script src="{{ asset('plugins/jquery-3.6.4.min.js') }}"></script>

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
    <script src="{{ asset('plugins/jquery-nested-sortable.js') }}"></script>

    @vite('resources/js/dashboard/main.js')
</body>

</html>
