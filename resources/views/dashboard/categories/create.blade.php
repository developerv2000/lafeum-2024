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

    <x-dashboard.form-templates.create-template :action="route('dashboard.categories.store', ['model' => $model])">
        <div class="form__block">
            <div class="form__row">
                <x-form.inputs.default-input
                    labelText="Имя"
                    inputName="name"
                    :isRequired="true" />

                <x-form.selects.selectize.id-based-single-select.default-select
                    labelText="Родитель"
                    inputName="parent_id"
                    :options="$roots" />
            </div>

            <x-form.textareas.default-textarea
                labelText="Текст"
                inputName="description"
                :isRequired="true" />
        </div>
    </x-dashboard.form-templates.create-template>
@endsection
