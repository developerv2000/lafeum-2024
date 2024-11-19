@extends('dashboard.layouts.app', [
    'pageName' => 'videos-trash',
    'mainAutoOverflowed' => true,
])

@section('content')
    <div class="main-box styled-box">
        {{-- Toolbar --}}
        <div class="toolbar toolbar--joined toolbar--for-table">
            {{-- blade-formatter-disable --}}
            @php
                $crumbs = [
                    ['link' => route('dashboard.videos.index'), 'text' => 'Все видео'],
                    ['link' => null, 'text' => 'Корзина'],
                    ['link' => null, 'text' => 'Отфильтрованных записей — ' . $records->total()]
                ];
            @endphp
            {{-- blade-formatter-enable --}}

            <x-dashboard.layouts.breadcrumbs :crumbs="$crumbs" />

            {{-- Toolbar buttons --}}
            <div class="toolbar__buttons-wrapper">
                <x-global.button
                    class="toolbar__button"
                    style="shadowed"
                    icon="delete"
                    data-click-action="show-modal"
                    data-modal-selector=".multiple-delete-modal">Удалить навсегда
                </x-global.button>

                <x-global.button
                    class="toolbar__button"
                    style="shadowed"
                    icon="history"
                    data-click-action="show-modal"
                    data-modal-selector=".multiple-restore-modal">Восстановить
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

        {{-- Table --}}
        <x-dashboard.tables.videos-table :records="$records" :trashedRecords="true" />
    </div>

    {{-- Modals --}}
    <x-dashboard.modals.multiple-delete form-action="{{ route('dashboard.videos.destroy') }}" :force-delete="true" />
    <x-dashboard.modals.target-delete :force-delete="true" />
    <x-dashboard.modals.multiple-restore form-action="{{ route('dashboard.videos.restore') }}" />
    <x-dashboard.modals.target-restore />
@endsection

@section('rightbar')
    <x-dashboard.filters.videos />
@endsection
