@props(['folder'])

<div class="manage-folders__list-actions">
    <x-global.button class="manage-folders__list-action-button"
        style="transparent"
        icon="edit"
        title="Переименовать"
        data-click-action="rename-folder"
        data-folder-id="{{ $folder->id }}"
        data-folder-name="{{ $folder->name }}"></x-global.button>

    <x-global.button class="manage-folders__list-action-button"
        style="transparent"
        icon="delete"
        title="Удалить"
        data-click-action="destroy-folder"
        data-folder-id="{{ $folder->id }}"></x-global.button>
</div>
