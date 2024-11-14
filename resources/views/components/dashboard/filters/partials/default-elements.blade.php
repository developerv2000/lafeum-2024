@props(['elements' => ['created_at', 'updated_at', 'id[]', 'pagination_limit']])

<x-form.inputs.request-based-input
    labelText="Дата создания"
    inputName="created_at"
    class="date-range-input"
    autocomplete="off" />

<x-form.inputs.request-based-input
    labelText="Дата обновления"
    inputName="updated_at"
    class="date-range-input"
    autocomplete="off" />

<x-form.selects.selectize.multiple-select.request-based-select
    labelText="ID"
    inputName="id[]"
    :options="request()->input('id', [])"
    :taggable="true" />

<x-dashboard.filters.partials.pagination-limit />
