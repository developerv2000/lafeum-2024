@extends('dashboard.layouts.app', [
    'pageName' => 'categories-create',
    'mainAutoOverflowed' => false,
])

@section('content')
    <div class="toolbar">
        {{-- blade-formatter-disable --}}
        @php
            $crumbs = [
                ['link' => null, 'text' => $model],
                ['link' => route('dashboard.categories.index', ['model' => $model]), 'text' => 'Все категории'],
                ['link' => null, 'text' => 'Изменить структуру'],
            ];
        @endphp
        {{-- blade-formatter-enable --}}

        <x-dashboard.layouts.breadcrumbs :crumbs="$crumbs" />

        <div class="toolbar__buttons-wrapper">
            <x-global.button
                class="toolbar__button"
                style="shadowed"
                data-click-action="submit-nestedset-update"
                :data-form-action="route('dashboard.categories.update.nestedset', ['model' => $model])"
                icon="done_all">Обновить
            </x-global.button>
        </div>
    </div>

    <x-dashboard.layouts.nestedset :records="$records" />
@endsection
