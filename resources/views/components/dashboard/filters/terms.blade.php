<x-dashboard.filters.layout>
    <x-form.selects.selectize.id-based-multiple-select.request-based-select
        labelText="Заголовок"
        inputName="id[]"
        :options="$namedTerms" />

    <x-form.selects.selectize.id-based-single-select.request-based-select
        labelText="Тип"
        inputName="term_type_id"
        :options="$types" />

    <x-form.selects.selectize.boolean-select.request-based-select
        labelText="Словарь"
        inputName="show_in_vocabulary" />

    <x-form.selects.selectize.id-based-multiple-select.request-based-select
        labelText="Категории"
        inputName="categories[]"
        :options="$categories" />

    <x-form.selects.selectize.id-based-multiple-select.request-based-select
        labelText="Область знаний"
        inputName="knowledges[]"
        :options="$knowledges" />

    <x-form.inputs.request-based-input
        labelText="Текст"
        inputName="body" />

    {{-- Default filter inputs --}}
    <x-dashboard.filters.partials.default-inputs />
</x-dashboard.filters.layout>
