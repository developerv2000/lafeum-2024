<x-dashboard.filters.layout>
    <x-form.inputs.request-based-input
        labelText="Имя"
        inputName="name" />

    <x-form.selects.selectize.id-based-single-select.request-based-select
        labelText="Группа"
        inputName="author_group_id"
        :options="$groups" />

    {{-- Default filter inputs --}}
    <x-dashboard.filters.partials.default-inputs />
</x-dashboard.filters.layout>
