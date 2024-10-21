@extends('dashboard.layouts.app', [
    'pageName' => 'quotes-index',
])

@section('content')
    <h1 class="main-title">Все цитаты — 2000 элементов</h1>
    <x-dashboard.searches.keyworded />

    <div class="toolbar">
        <x-global.buttoned-link
            class="toolbar__button"
            link="{{ route('dashboard.quotes.create') }}"
            icon="add">Новый
        </x-global.buttoned-link>

        <x-global.button
            class="toolbar__button"
            icon="delete">Удалить
        </x-global.button>

        <x-global.button
            class="toolbar__button"
            icon="fullscreen"
            data-click-action="request-fullscreen"
            data-target-selector="{{ '.main-table' }}">Fullscreen
        </x-global.button>
    </div>

    @include('dashboard.tables.quotes')
@endsection
