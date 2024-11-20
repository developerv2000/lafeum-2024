@extends('dashboard.layouts.app', [
    'pageName' => 'channels-create',
    'mainAutoOverflowed' => false,
])

@section('content')
    <div class="toolbar">
        {{-- blade-formatter-disable --}}
        @php
            $crumbs = [
                ['link' => route('dashboard.channels.index'), 'text' => 'Все каналы'],
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

    <x-dashboard.form-templates.create-template :action="route('dashboard.channels.store')">
        <div class="form__block">
            <x-form.inputs.default-input
                labelText="Имя"
                inputName="name"
                :isRequired="true" />

            <x-form.textareas.default-textarea
                class="simditor"
                labelText="Описание"
                inputName="description" />
        </div>
    </x-dashboard.form-templates.create-template>
@endsection
