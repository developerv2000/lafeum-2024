@extends('dashboard.layouts.app', [
    'pageName' => 'authors-edit',
    'mainAutoOverflowed' => false,
])

@section('content')
    <div class="toolbar">
        {{-- blade-formatter-disable --}}
        @php
            $crumbs = [
                ['link' => route('dashboard.authors.index'), 'text' => 'Все авторы'],
            ];

            if ($record->trashed()) {
                $crumbs[] = ['link' => route('dashboard.authors.trash'), 'text' => 'Корзина'];
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

    <x-dashboard.form-templates.edit-template :action="route('dashboard.authors.update', $record->id)">
        <div class="form__block">
            <div class="form__row">
                <x-form.inputs.record-field-input
                    labelText="Имя"
                    :model="$record"
                    field="name"
                    :isRequired="true" />

                <x-form.selects.selectize.id-based-single-select.record-field-select
                    labelText="Группа"
                    :model="$record"
                    field="author_group_id"
                    :options="$groups"
                    :isRequired="true" />
            </div>
        </div>

        <div class="form__block">
            <x-form.image-inputs-with-preview.default-input
                labelText="Фото"
                accept=".png, .jpg, .jpeg"
                inputName="photo"
                :initialImageSrc="$record->photo_asset_url" />
        </div>

        <div class="form__block">
            <x-form.textareas.record-field-textarea
                class="simditor"
                labelText="Биография"
                :model="$record"
                field="biography" />
        </div>
    </x-dashboard.form-templates.edit-template>
@endsection
