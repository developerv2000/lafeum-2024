<x-dashboard.filters.layout>
    <x-form.inputs.request-based-input
        labelText="Заголовок"
        inputName="title" />

    <x-form.selects.selectize.id-based-multiple-select.request-based-select
        labelText="Канал"
        inputName="channel_id[]"
        :options="$channels" />

    <x-form.selects.selectize.id-based-multiple-select.request-based-select
        labelText="Категории"
        inputName="categories[]"
        :options="$categories" />

    {{-- Default filter inputs --}}
    <x-dashboard.filters.partials.default-inputs />
</x-dashboard.filters.layout>
