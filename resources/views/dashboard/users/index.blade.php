@extends('dashboard.layouts.app', [
    'pageName' => 'users-index',
    'mainAutoOverflowed' => true,
])

@section('content')
    <div class="main-box styled-box">
        {{-- Toolbar --}}
        <div class="toolbar toolbar--joined toolbar--for-table">
            {{-- blade-formatter-disable --}}
            @php
                $crumbs = [
                    ['link' => null, 'text' => 'Все пользователи'],
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

        {{-- Table --}}
        <x-dashboard.tables.users-table :records="$records" />
    </div>

    {{-- Modals --}}
    <x-dashboard.modals.multiple-delete form-action="{{ route('dashboard.users.destroy') }}" :force-delete="false" />
@endsection

@section('rightbar')
    <x-dashboard.filters.users />
@endsection
