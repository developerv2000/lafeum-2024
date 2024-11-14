<x-dashboard.filters.layout>
    <x-form.selects.selectize.id-based-multiple-select.request-based-select
        labelText="Автор"
        inputName="author_id[]"
        :options="$authors" />

    <x-form.selects.selectize.id-based-multiple-select.request-based-select
        labelText="Категории"
        inputName="categories[]"
        :options="$categories" />

    <x-form.inputs.request-based-input
        labelText="Цитата"
        inputName="body" />

    <x-form.inputs.request-based-input
        labelText="Мысли автора"
        inputName="notes" />

    {{-- Default filter inputs --}}
    <x-dashboard.filters.partials.default-inputs />
</x-dashboard.filters.layout>
