@extends('dashboard.layouts.app', [
    'pageName' => 'channels-edit',
    'mainAutoOverflowed' => false,
])

@section('content')
    <div class="toolbar">
        {{-- blade-formatter-disable --}}
        @php
            $crumbs = [
                ['link' => route('dashboard.channels.index'), 'text' => 'Все каналы'],
            ];

            if ($record->trashed()) {
                $crumbs[] = ['link' => route('dashboard.channels.trash'), 'text' => 'Корзина'];
            }

            array_push($crumbs,
                ['link' => null, 'text' => 'Редактировать'],
                ['link' => null, 'text' => '#' . $record->id],
            )
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

    <x-dashboard.form-templates.edit-template :action="route('dashboard.channels.update', $record->id)">
        <div class="form__block">
            <x-form.inputs.record-field-input
                labelText="Имя"
                :model="$record"
                field="name"
                :isRequired="true" />

            <x-form.textareas.record-field-textarea
                class="simditor"
                labelText="Описание"
                :model="$record"
                field="description" />
        </div>
    </x-dashboard.form-templates.edit-template>
@endsection
