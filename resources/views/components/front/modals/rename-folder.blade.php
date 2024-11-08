<x-global.modal class="rename-folder-modal" title="Переименовать папку">
    <x-slot:body>
        <form class="rename-folder-form" id="rename-folder-form" action="{{ route('folders.rename') }}" method="POST">
            @csrf
            @method('PATCH')

            <input type="hidden" name="id">
            <input class="input" type="text" name="name" required>
        </form>
    </x-slot:body>

    <x-slot:footer>
        <x-global.button style="cancel" data-click-action="hide-visible-modal">Отмена</x-global.button>
        <x-global.button style="main" type="submit" form="rename-folder-form">Переименовать</x-global.button>
    </x-slot:footer>
</x-global.modal>
