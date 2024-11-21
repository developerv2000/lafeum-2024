<x-dashboard.filters.layout>
    <x-form.inputs.request-based-input
        labelText="Имя"
        inputName="name" />

    <x-form.inputs.request-based-input
        labelText="Почта"
        inputName="email" />

    <x-form.inputs.request-based-input
        labelText="Тема"
        inputName="theme" />

    {{-- Default filter inputs --}}
    <x-dashboard.filters.partials.default-inputs />
</x-dashboard.filters.layout>
