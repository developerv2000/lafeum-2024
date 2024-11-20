@extends('dashboard.layouts.app', [
    'pageName' => 'authors-create',
    'mainAutoOverflowed' => false,
])

@section('content')
    <div class="toolbar">
        {{-- blade-formatter-disable --}}
        @php
            $crumbs = [
                ['link' => route('dashboard.authors.index'), 'text' => 'Все авторы'],
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

    <x-dashboard.form-templates.create-template :action="route('dashboard.authors.store')">
        <div class="form__block">
            <div class="form__row">
                <x-form.inputs.default-input
                    labelText="Имя"
                    inputName="name"
                    :isRequired="true" />

                <x-form.selects.selectize.id-based-single-select.default-select
                    labelText="Группа"
                    inputName="author_group_id"
                    :options="$groups"
                    :isRequired="true" />
            </div>
        </div>

        <div class="form__block">
            <x-form.image-inputs-with-preview.default-input
                labelText="Фото"
                accept=".png, .jpg, .jpeg"
                inputName="photo" />
        </div>

        <div class="form__block">
            <x-form.textareas.default-textarea
                class="simditor"
                labelText="Биография"
                inputName="biography" />
        </div>
    </x-dashboard.form-templates.create-template>
@endsection
