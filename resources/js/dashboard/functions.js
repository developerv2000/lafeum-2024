/*
|--------------------------------------------------------------------------
| Necessary dependencies
|--------------------------------------------------------------------------
*/

import { showModal } from "../../custom-components/script";

/*
|--------------------------------------------------------------------------
| Constants
|--------------------------------------------------------------------------
*/

const TOGGLE_LEFTBAR_URL = '/dashboard/settings/collapsed-leftbar';

/*
|--------------------------------------------------------------------------
| DOM Elements
|--------------------------------------------------------------------------
*/

const leftbar = document.querySelector('.leftbar');
const targetDeleteModal = document.querySelector('.target-delete-modal');

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
*/

export function toggleTextMaxLines(target) {
    target.closest('[data-on-click="toggle-td-text-max-lines"]').classList.toggle('td__max-lines-limited-text');
}

export function toggleLeftbar() {
    axios.patch(TOGGLE_LEFTBAR_URL)
        .finally(() => {
            leftbar.classList.toggle('leftbar--collapsed');
        });
}

export function toggleTableCheckboxes(table) {
    const checkboxes = table.querySelectorAll('.td__checkbox');
    const checkedAll = table.querySelector('.td__checkbox:not(:checked)') ? false : true;

    checkboxes.forEach((checkbox) => {
        checkbox.checked = !checkedAll;
    });
}

function exitFullscreen(target) {
    target.classList.remove('fullscreen');
    if (document.exitFullscreen) {
        document.exitFullscreen();
    } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
    }
};

export function enterFullscreen(target) {
    if (target.requestFullscreen) {
        target.requestFullscreen();
    } else if (target.webkitRequestFullscreen) {
        target.webkitRequestFullscreen();
    } else if (target.msRequestFullscreen) {
        target.msRequestFullscreen();
    }
};

export function toggleFullscreenClass(target) {
    if (document.fullscreenElement) {
        target.classList.add('fullscreen');
    } else {
        target.classList.remove('fullscreen');
    }
};

export function appendFormInputsBeforeSubmit(evt) {
    evt.preventDefault();
    const form = evt.target;
    const inputs = document.querySelectorAll(form.dataset.inputsSelector);

    // Append each input to the form
    const inputsContainer = form.querySelector('.form__hidden-appended-inputs-container');

    inputs.forEach((input) => {
        const inputCopy = input.cloneNode(true);
        inputsContainer.appendChild(inputCopy);
    });

    form.submit();
}

export function showTargetDeleteModal(button) {
    // Update form before modal show
    const form = targetDeleteModal.querySelector('form');
    const idInput = targetDeleteModal.querySelector('input[name="id"]');

    idInput.value = button.dataset.targetId;
    form.action = button.dataset.formAction;

    showModal(targetDeleteModal);
}
