@extends('dashboard.layouts.app', [
    'pageName' => 'quotes-index',
])

@section('content')
    <div class="main-box styled-box">
        <div class="toolbar">
            <h1 class="toolbar__title">Отфильтрованных записей — {{ $records->total() }}</h1>

            <div class="toolbar__buttons-wrapper">
                <x-global.buttoned-link
                    class="toolbar__button"
                    style="shadowed"
                    link="{{ route('dashboard.quotes.create') }}"
                    icon="add">Добавить
                </x-global.buttoned-link>

                <x-global.button
                    class="toolbar__button"
                    style="shadowed"
                    icon="delete"
                    data-click-action="show-modal"
                    data-modal-selector=".multiple-delete-modal">Удалить
                </x-global.button>

                <x-global.button
                    class="toolbar__button"
                    style="shadowed"
                    icon="fullscreen"
                    data-click-action="request-fullscreen"
                    data-target-selector="{{ '.main-wrapper' }}">На весь экран
                </x-global.button>
            </div>
        </div>

        @include('dashboard.tables.quotes')
    </div>

    <x-dashboard.modals.multiple-delete form-action="{{ route('dashboard.quotes.destroy') }}" :force-delete="false" />
    <x-dashboard.modals.target-delete :force-delete="false" />
@endsection

@section('rightbar')
    @include('dashboard.filters.quotes')
@endsection
