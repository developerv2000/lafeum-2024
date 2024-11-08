<x-global.modal class="destroy-folder-modal" title="Удалить папку">
    <x-slot:body>
        <form class="destroy-folder-form" id="destroy-folder-form" action="{{ route('folders.destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="id">

            Вы уверены что хотите удалить папку?
        </form>
    </x-slot:body>

    <x-slot:footer>
        <x-global.button style="cancel" data-click-action="hide-visible-modal">Отмена</x-global.button>
        <x-global.button style="danger" type="submit" form="destroy-folder-form">Удалить</x-global.button>
    </x-slot:footer>
</x-global.modal>
