@extends('dashboard.layouts.app', [
    'pageName' => 'terms-create',
    'mainAutoOverflowed' => false,
])

@section('content')
    <div class="toolbar">
        {{-- blade-formatter-disable --}}
        @php
            $crumbs = [
                ['link' => route('dashboard.terms.index'), 'text' => 'Все термины'],
                ['link' => null, 'text' => 'Добавить'],
            ];
        @endphp
        {{-- blade-formatter-enable --}}

        <x-dashboard.layouts.breadcrumbs :crumbs="$crumbs" />

        <div class="toolbar__buttons-wrapper">
            <x-global.button
                class="toolbar__button"
                style="shadowed"
                type="submit"
                form="create-form"
                icon="done_all">Добавить
            </x-global.button>
        </div>
    </div>

    <x-dashboard.form-templates.create-template :action="route('dashboard.terms.store')">
        <div class="form__block">
            <div class="form__row">
                <x-form.inputs.default-input
                    labelText="Название (Словарь)"
                    inputName="name" />

                <x-form.inputs.default-input
                    labelText="Дата публикации"
                    type="datetime-local"
                    inputName="publish_at"
                    :isRequired="true" />
            </div>
        </div>

        <div class="form__block">
            <div class="form__row">
                <x-form.radio-buttons.default-radio-buttons
                    class="radio-group--horizontal"
                    labelText="Словарь"
                    inputName="show_in_vocabulary"
                    :options="$booleanOptions"
                    :isRequired="true" />
            </div>
        </div>

        <div class="form__block">
            <div class="form__row">
                <x-form.selects.selectize.id-based-single-select.default-select
                    labelText="Тип"
                    inputName="term_type_id"
                    :options="$types"
                    :isRequired="true" />

                <x-form.selects.selectize.id-based-multiple-select.default-select
                    labelText="Категории"
                    inputName="categories[]"
                    :options="$categories"
                    :isRequired="true" />

                <x-form.selects.selectize.id-based-multiple-select.default-select
                    labelText="Область знаний"
                    inputName="knowledges[]"
                    :options="$knowledges"
                    :isRequired="true" />
            </div>
        </div>

        <div class="form__block">
            <x-form.textareas.default-textarea
                class="simditor"
                labelText="Текст"
                inputName="body"
                :isRequired="true" />
        </div>
    </x-dashboard.form-templates.create-template>
@endsection
