@extends('dashboard.layouts.app', [
    'pageName' => 'videos-create',
    'mainAutoOverflowed' => false,
])

@section('content')
    <div class="toolbar">
        {{-- blade-formatter-disable --}}
        @php
            $crumbs = [
                ['link' => route('dashboard.videos.index'), 'text' => 'Все видео'],
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

    <x-dashboard.form-templates.create-template :action="route('dashboard.videos.store')">
        <div class="form__block">
            <div class="form__row">
                <x-form.inputs.default-input
                    labelText="Заголовок"
                    inputName="title"
                    :isRequired="true" />

                <x-form.selects.selectize.id-based-single-select.default-select
                    labelText="Канал"
                    inputName="channel_id"
                    :options="$channels"
                    :isRequired="true" />

                <x-form.inputs.default-input
                    labelText="Ссылка"
                    inputName="youtube_link"
                    :isRequired="true" />
            </div>

            <div class="form__row">
                <x-form.selects.selectize.id-based-multiple-select.default-select
                    labelText="Категории"
                    inputName="categories[]"
                    :options="$categories"
                    :isRequired="true" />

                <x-form.inputs.default-input
                    labelText="Продолжительность"
                    inputName="duration"
                    :isRequired="true" />

                <x-form.inputs.default-input
                    labelText="Дата публикации"
                    type="datetime-local"
                    inputName="publish_at"
                    :isRequired="true" />
            </div>
        </div>
    </x-dashboard.form-templates.create-template>
@endsection
