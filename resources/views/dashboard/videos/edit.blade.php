@extends('dashboard.layouts.app', [
    'pageName' => 'videos-edit',
    'mainAutoOverflowed' => false,
])

@section('content')
    <div class="toolbar">
        {{-- blade-formatter-disable --}}
        @php
            $crumbs = [
                ['link' => route('dashboard.videos.index'), 'text' => 'Все видео'],
            ];

            if ($record->trashed()) {
                $crumbs[] = ['link' => route('dashboard.videos.trash'), 'text' => 'Корзина'];
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

    <x-dashboard.form-templates.edit-template :action="route('dashboard.videos.update', $record->id)">
        <div class="form__block">
            <div class="form__row">
                <x-form.inputs.record-field-input
                    labelText="Заголовок"
                    :model="$record"
                    field="title"
                    :isRequired="true" />

                <x-form.selects.selectize.id-based-single-select.record-field-select
                    labelText="Канал"
                    :model="$record"
                    field="channel_id"
                    :options="$channels"
                    :isRequired="true" />

                <x-form.inputs.record-field-input
                    labelText="Ссылка"
                    :model="$record"
                    field="youtube_link"
                    readonly />
            </div>

            <div class="form__row">
                <x-form.selects.selectize.id-based-multiple-select.record-relation-select
                    labelText="Категории"
                    :model="$record"
                    inputName="categories[]"
                    :options="$categories"
                    :isRequired="true" />

                <x-form.inputs.record-field-input
                    labelText="Продолжительность"
                    :model="$record"
                    field="duration"
                    :isRequired="true" />

                <x-form.inputs.record-field-input
                    labelText="Дата публикации"
                    type="datetime-local"
                    :model="$record"
                    field="publish_at"
                    :isRequired="true"
                    min="{{ date('Y') - 20 }}-01-01T00:00"
                    max="{{ date('Y') + 20 }}-01-01T00:00" />
            </div>
        </div>

        <div class="form__block">
            <x-form.inputs.default-input
                labelText="Новая ссылка"
                inputName="new_youtube_link"
                :isRequired="false" />
        </div>
    </x-dashboard.form-templates.edit-template>
@endsection
