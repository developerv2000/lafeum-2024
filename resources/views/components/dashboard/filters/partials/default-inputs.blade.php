@props(['exclude' => []])

@unless (in_array('created_at', $exclude))
    <x-form.inputs.request-based-input
        labelText="Дата создания"
        inputName="created_at"
        class="date-range-picker-input"
        autocomplete="off" />
@endunless

@unless (in_array('updated_at', $exclude))
    <x-form.inputs.request-based-input
        labelText="Дата обновления"
        inputName="updated_at"
        class="date-range-picker-input"
        autocomplete="off" />
@endunless

@unless (in_array('id', $exclude))
    <x-form.selects.selectize.multiple-select.request-based-select
        labelText="ID"
        inputName="id[]"
        :options="request()->input('id', [])"
        :taggable="true" />
@endunless

@unless (in_array('pagination_limit', $exclude))
    <x-dashboard.filters.partials.pagination-limit-input />
@endunless
