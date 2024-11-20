<x-dashboard.filters.layout>
    <x-form.inputs.request-based-input
        labelText="Имя"
        inputName="name" />

    <x-form.inputs.request-based-input
        labelText="Почта"
        inputName="email" />

    <x-form.selects.selectize.id-based-single-select.request-based-select
        labelText="Пол"
        inputName="gender_id"
        :options="$genders" />

    <x-form.selects.selectize.id-based-single-select.request-based-select
        labelText="Страна"
        inputName="country_id"
        :options="$countries" />

        <x-form.inputs.request-based-input
        labelText="IP адрес"
        inputName="registered_ip_address" />

        <x-form.inputs.request-based-input
        labelText="Браузер"
        inputName="registered_browser" />

        <x-form.inputs.request-based-input
        labelText="Устройство"
        inputName="registered_device" />

        <x-form.inputs.request-based-input
        labelText="Страна при рег."
        inputName="registered_country" />

    {{-- Default filter inputs --}}
    <x-dashboard.filters.partials.default-inputs />
</x-dashboard.filters.layout>
