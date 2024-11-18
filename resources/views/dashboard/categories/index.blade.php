@extends('dashboard.layouts.app', [
    'pageName' => 'categories-index',
    'mainAutoOverflowed' => true,
])

@section('content')
    <div class="main-box styled-box">
        {{-- Toolbar --}}
        <div class="toolbar toolbar--joined toolbar--for-table">
            {{-- blade-formatter-disable --}}
            @php
                $crumbs = [
                    ['link' => null, 'text' => 'Все категории'],
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
                    link="{{ route('dashboard.categories.create', ['model' => $model]) }}"
                    icon="add">Добавить
                </x-global.buttoned-link>

                <x-global.buttoned-link
                    class="toolbar__button"
                    style="shadowed"
                    link="{{ route('dashboard.categories.edit.nestedset', ['model' => $model]) }}"
                    icon="sort">Изменить структуру
                </x-global.buttoned-link>

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
        <x-dashboard.tables.categories-table :model="$model" :records="$records" />
    </div>
@endsection
