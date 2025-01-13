@extends('dashboard.layouts.app', [
    'pageName' => 'photos-create',
    'mainAutoOverflowed' => false,
])

@section('content')
    <div class="toolbar">
        {{-- blade-formatter-disable --}}
        @php
            $crumbs = [
                ['link' => route('dashboard.photos.index'), 'text' => 'Все фото'],
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

    <x-dashboard.form-templates.create-template :action="route('dashboard.photos.store')">
        <div class="form__block">
            <x-form.image-inputs-with-preview.default-input
                labelText="Фото"
                accept=".png, .jpg, .jpeg"
                inputName="filename" />
        </div>

        <div class="form__block">
            <x-form.inputs.default-input
                labelText="Дата публикации"
                type="datetime-local"
                inputName="publish_at"
                :isRequired="true"
                min="{{ date('Y') - 20 }}-01-01T00:00"
                max="{{ date('Y') + 20 }}-01-01T00:00" />

            <x-form.textareas.default-textarea
                labelText="Описание"
                inputName="description" />
        </div>
    </x-dashboard.form-templates.create-template>
@endsection
