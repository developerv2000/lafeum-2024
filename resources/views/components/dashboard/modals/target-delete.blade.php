@props(['forceDelete'])

<x-global.modal class="target-delete-modal" title="Удалить запись?">
    <x-slot:body>
        <form
            class="target-delete-form"
            id="target-delete-form"
            action="#" {{-- Updates by JS --}}
            method="POST">

            @csrf
            @method('DELETE')

            <input type="hidden" name="id"> {{-- Value updates by JS --}}

            {{-- Force delete on trash pages --}}
            @if ($forceDelete)
                <input type="hidden" name="force_delete" value="1">
            @endif

            <p>Вы уверены, что хотите удалить запись?</p>
            <p>Также, удалятся все связанные с ним записи!</p>
        </form>
    </x-slot:body>

    <x-slot:footer>
        <x-global.button style="cancel" data-click-action="hide-visible-modal">Отмена</x-global.button>
        <x-global.button style="danger" type="submit" form="target-delete-form">Удалить</x-global.button>
    </x-slot:footer>
</x-global.modal>
