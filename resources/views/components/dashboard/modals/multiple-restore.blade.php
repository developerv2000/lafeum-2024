@props(['formAction'])

<x-global.modal class="multiple-restore-modal" title="Восстановление записей">
    <x-slot:body>
        <form
            class="multiple-restore-form"
            id="multiple-restore-form"
            action="{{ $formAction }}"
            method="POST"
            data-before-submit="appends-inputs"
            data-inputs-selector=".main-table .td__checkbox">

            @csrf
            @method('PATCH')

            <p>Вы уверены, что хотите восстановить отмеченные записи?</p>

            {{-- Used to hold appended checkbox inputs before submiting form by JS --}}
            <div class="form__hidden-appended-inputs-container"></div>
        </form>
    </x-slot:body>

    <x-slot:footer>
        <x-global.button style="cancel" data-click-action="hide-visible-modal">Отмена</x-global.button>
        <x-global.button style="success" type="submit" form="multiple-restore-form">Восстановить</x-global.button>
    </x-slot:footer>
</x-global.modal>
