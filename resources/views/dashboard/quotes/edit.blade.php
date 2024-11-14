@extends('dashboard.layouts.app', [
    'pageName' => 'quotes-edit',
    'mainAutoOverflowed' => false,
])

@section('content')
    <div class="toolbar">
        {{-- blade-formatter-disable --}}
        <x-dashboard.layouts.breadcrumbs :crumbs="[
            ['link' => route('dashboard.quotes.index'), 'text' => 'Все цитаты'],
            ['link' => null, 'text' => 'Редактировать'],
            ['link' => null, 'text' => '#' . $record->id],
        ]" />
        {{-- blade-formatter-enable --}}

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

    <x-dashboard.form-templates.edit-template :action="route('dashboard.quotes.update', $record->id)">
        <div class="form__block">
            <x-form.inputs.record-field-input
                labelText="Body"
                :model="$record"
                field="body"
                :isRequired="true" />

            <x-form.selects.selectize.id-based-single-select.record-field-select
                labelText="Author"
                :model="$record"
                field="author_id"
                :options="$authors"
                :isRequired="true" />

            <x-form.selects.selectize.id-based-multiple-select.record-relation-select
                labelText="Categories"
                :model="$record"
                inputName="categories[]"
                :options="$categories"
                :isRequired="true" />
        </div>
    </x-dashboard.form-templates.edit-template>
@endsection
