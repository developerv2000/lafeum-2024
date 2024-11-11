@props(['formAction', 'recordId'])

<td>
    <x-global.button
        style="transparent"
        class="td__delete"
        icon="delete"
        title="Удалить"
        data-click-action="show-target-delete-modal"
        :data-form-action="$formAction"
        :data-target-id="$recordId" />
</td>
