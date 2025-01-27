@extends('dashboard.layouts.app', [
    'pageName' => 'quotes-edit',
    'mainAutoOverflowed' => false,
])

@section('content')
    <div class="toolbar">
        {{-- blade-formatter-disable --}}
        @php
            $crumbs = [
                ['link' => route('dashboard.quotes.index'), 'text' => 'Все цитаты'],
            ];

            if ($record->trashed()) {
                $crumbs[] = ['link' => route('dashboard.quotes.trash'), 'text' => 'Корзина'];
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

    <x-dashboard.form-templates.edit-template :action="route('dashboard.quotes.update', $record->id)">
        <div class="form__block">
            <div class="form__row">
                <x-form.selects.selectize.id-based-single-select.record-field-select
                    labelText="Автор"
                    :model="$record"
                    field="author_id"
                    :options="$authors"
                    :isRequired="true" />

                <x-form.inputs.record-field-input
                    labelText="Дата публикации"
                    type="datetime-local"
                    :model="$record"
                    field="publish_at"
                    :initialValue="$record->formatForDateTimeInput('publish_at')"
                    :isRequired="true"
                    min="{{ date('Y') - 20 }}-01-01T00:00"
                    max="{{ date('Y') + 20 }}-01-01T00:00" />

                <x-form.selects.selectize.id-based-multiple-select.record-relation-select
                    labelText="Категории"
                    :model="$record"
                    inputName="categories[]"
                    :options="$categories"
                    :isRequired="true" />
            </div>
        </div>

        <div class="form__block">
            <div class="form__row">
                <x-form.textareas.record-field-textarea
                    class="simditor"
                    labelText="Текст"
                    :model="$record"
                    field="body"
                    :isRequired="true" />

                <x-form.textareas.record-field-textarea
                    class="simditor"
                    labelText="Мысли автора"
                    :model="$record"
                    field="notes" />
            </div>
        </div>
    </x-dashboard.form-templates.edit-template>
@endsection
