/*
|--------------------------------------------------------------------------
| Constants
|--------------------------------------------------------------------------
*/

const TOGGLE_LEFTBAR_URL = '/settings/collapsed-leftbar';

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
    leftbar.classList.toggle('leftbar--collapsed');
}
