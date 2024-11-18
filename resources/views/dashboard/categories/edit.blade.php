@extends('dashboard.layouts.app', [
    'pageName' => 'categories-edit',
    'mainAutoOverflowed' => false,
])

@section('content')
    <div class="toolbar">
        {{-- blade-formatter-disable --}}
        @php
            $crumbs = [
                ['link' => null, 'text' => $model],
                ['link' => route('dashboard.categories.index', ['model' => $model]), 'text' => 'Все категории'],
                ['link' => null, 'text' => 'Редактировать'],
                ['link' => null, 'text' => '#' . $record->id],
            ];
        @endphp
        {{-- blade-formatter-enable --}}

        <x-dashboard.layouts.breadcrumbs :crumbs="$crumbs" />

        <div class="toolbar__buttons-wrapper">
            <x-global.button
                class="toolbar__button"
                style="shadowed"
                type="submit"
                form="edit-form"
                icon="done_all">Сохранить
            </x-global.button>
        </div>
    </div>

    <x-dashboard.form-templates.edit-template :action="route('dashboard.categories.update', ['model' => $model, 'record' => $record->id])">
        <div class="form__block">
            <div class="form__row">
                <x-form.inputs.record-field-input
                    labelText="Имя"
                    :model="$record"
                    field="name"
                    :isRequired="true" />

                <x-form.selects.selectize.id-based-single-select.record-field-select
                    labelText="Родитель"
                    :model="$record"
                    field="parent_id"
                    :options="$roots" />
            </div>

            <x-form.textareas.record-field-textarea
                labelText="Текст"
                :model="$record"
                field="description"
                :isRequired="true" />
        </div>
    </x-dashboard.form-templates.edit-template>
@endsection
