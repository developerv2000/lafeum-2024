@extends('dashboard.layouts.app', [
    'pageName' => 'quotes-create',
    'mainAutoOverflowed' => false,
])

@section('content')
    <div class="toolbar">
        {{-- blade-formatter-disable --}}
        @php
            $crumbs = [
                ['link' => route('dashboard.quotes.index'), 'text' => 'Все цитаты'],
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

    <x-dashboard.form-templates.create-template :action="route('dashboard.quotes.store')">
        <div class="form__block">
            <div class="form__row">
                <x-form.selects.selectize.id-based-single-select.default-select
                    labelText="Автор"
                    inputName="author_id"
                    :options="$authors"
                    :isRequired="true" />

                <x-form.inputs.default-input
                    labelText="Дата публикации"
                    type="datetime-local"
                    inputName="publish_at"
                    :isRequired="true"
                    min="{{ date('Y') - 20 }}-01-01T00:00"
                    max="{{ date('Y') + 20 }}-01-01T00:00" />

                <x-form.selects.selectize.id-based-multiple-select.default-select
                    labelText="Категории"
                    inputName="categories[]"
                    :options="$categories"
                    :isRequired="true" />
            </div>
        </div>

        <div class="form__block">
            <div class="form__row">
                <x-form.textareas.default-textarea
                    class="simditor"
                    labelText="Текст"
                    inputName="body"
                    :isRequired="true" />

                <x-form.textareas.default-textarea
                    class="simditor"
                    labelText="Мысли автора"
                    inputName="notes" />
            </div>
        </div>
    </x-dashboard.form-templates.create-template>
@endsection
