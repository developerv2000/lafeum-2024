@extends('dashboard.layouts.app', [
    'pageName' => 'terms-edit',
    'mainAutoOverflowed' => false,
])

@section('content')
    <div class="toolbar">
        {{-- blade-formatter-disable --}}
        @php
            $crumbs = [
                ['link' => route('dashboard.terms.index'), 'text' => 'Все термины'],
            ];

            if ($record->trashed()) {
                $crumbs[] = ['link' => route('dashboard.terms.trash'), 'text' => 'Корзина'];
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

    <x-dashboard.form-templates.edit-template :action="route('dashboard.terms.update', $record->id)">
        <div class="form__block">
            <div class="form__row">
                <x-form.inputs.record-field-input
                    labelText="Название (Словарь)"
                    :model="$record"
                    field="name"
                    inputName="name" />

                <x-form.inputs.record-field-input
                    labelText="Дата публикации"
                    type="datetime-local"
                    :model="$record"
                    field="publish_at"
                    :initialValue="$record->formatForDateTimeInput('publish_at')"
                    :isRequired="true"
                    min="{{ date('Y') - 20 }}-01-01T00:00"
                    max="{{ date('Y') + 20 }}-01-01T00:00" />
            </div>
        </div>

        <div class="form__block">
            <div class="form__row">
                <x-form.radio-buttons.record-field-radio-buttons
                    class="radio-group--horizontal"
                    labelText="Словарь"
                    :model="$record"
                    field="show_in_vocabulary"
                    :options="$booleanOptions"
                    :isRequired="true" />
            </div>
        </div>

        <div class="form__block">
            <div class="form__row">
                <x-form.selects.selectize.id-based-single-select.record-field-select
                    labelText="Тип"
                    :model="$record"
                    field="term_type_id"
                    :options="$types"
                    :isRequired="true" />

                <x-form.selects.selectize.id-based-multiple-select.record-relation-select
                    labelText="Категории"
                    :model="$record"
                    inputName="categories[]"
                    :options="$categories"
                    :isRequired="true" />

                <x-form.selects.selectize.id-based-multiple-select.record-relation-select
                    labelText="Область знаний"
                    :model="$record"
                    inputName="knowledges[]"
                    :options="$knowledges"
                    :isRequired="true" />
            </div>
        </div>

        <div class="form__block">
            <x-form.textareas.record-field-textarea
                class="simditor"
                labelText="Текст"
                :model="$record"
                field="body"
                :isRequired="true" />
        </div>
    </x-dashboard.form-templates.edit-template>
@endsection
