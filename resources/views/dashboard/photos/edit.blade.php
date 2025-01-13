@extends('dashboard.layouts.app', [
    'pageName' => 'photos-edit',
    'mainAutoOverflowed' => false,
])

@section('content')
    <div class="toolbar">
        {{-- blade-formatter-disable --}}
        @php
            $crumbs = [
                ['link' => route('dashboard.photos.index'), 'text' => 'Все фото'],
            ];

            if ($record->trashed()) {
                $crumbs[] = ['link' => route('dashboard.photos.trash'), 'text' => 'Корзина'];
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

    <x-dashboard.form-templates.edit-template :action="route('dashboard.photos.update', $record->id)">
        <div class="form__block">
            <x-form.image-inputs-with-preview.default-input
                labelText="Фото"
                accept=".png, .jpg, .jpeg"
                inputName="filename"
                :initialImageSrc="$record->asset_url" />
        </div>

        <div class="form__block">
            <x-form.inputs.record-field-input
                labelText="Дата публикации"
                type="datetime-local"
                :model="$record"
                field="publish_at"
                :isRequired="true"
                min="{{ date('Y') - 20 }}-01-01T00:00"
                max="{{ date('Y') + 20 }}-01-01T00:00" />

            <x-form.textareas.record-field-textarea
                labelText="Мысли автора"
                :model="$record"
                field="notes" />
        </div>
    </x-dashboard.form-templates.edit-template>
@endsection
