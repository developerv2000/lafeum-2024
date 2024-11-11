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

    // toggle checkbox statements
    checkboxes.forEach((checkbox) => {
        checkbox.checked = !checkedAll;
    });
}

export function exitFullscreen (target) {
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
    console.log(target);
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

// function handleFullscreen
