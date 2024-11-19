@extends('dashboard.layouts.app', [
    'pageName' => 'photos-index',
    'mainAutoOverflowed' => true,
])

@section('content')
    <div class="main-box styled-box">
        {{-- Toolbar --}}
        <div class="toolbar toolbar--joined toolbar--for-table">
            {{-- blade-formatter-disable --}}
            @php
                $crumbs = [
                    ['link' => null, 'text' => 'Все фото'],
                    ['link' => null, 'text' => 'Отфильтрованных записей — ' . $records->total()]
                ];
            @endphp
            {{-- blade-formatter-enable --}}

            <x-dashboard.layouts.breadcrumbs :crumbs="$crumbs" />

            {{-- Toolbar buttons --}}
            <div class="toolbar__buttons-wrapper">
                <x-global.buttoned-link
                    class="toolbar__button"
                    style="shadowed"
                    link="{{ route('dashboard.photos.create') }}"
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

        {{-- Table --}}
        <x-dashboard.tables.photos-table :records="$records" />
    </div>

    {{-- Modals --}}
    <x-dashboard.modals.multiple-delete form-action="{{ route('dashboard.photos.destroy') }}" :force-delete="false" />
    <x-dashboard.modals.target-delete :force-delete="false" />
@endsection
