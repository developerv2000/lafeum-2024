/*
|--------------------------------------------------------------------------
| Necessary dependencies
|--------------------------------------------------------------------------
*/

import './bootstrap';
import * as functions from './functions';

/*
|--------------------------------------------------------------------------
| Constants
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| DOM Elements
|--------------------------------------------------------------------------
*/

const mainTable = document.querySelector('.main-table');
const leftbarToggler = document.querySelector('.header__leftbar-toggler');
const fullscreenButtons = document.querySelectorAll('[data-click-action="request-fullscreen"]');

/*
|--------------------------------------------------------------------------
| Event Listeners
|--------------------------------------------------------------------------
*/

/**
 * Handle main tables click events by delegating from child elements
 */
mainTable.addEventListener('click', (evt) => {
    const target = evt.target;

    // Text max lines toggling
    if (target.closest('[data-on-click="toggle-td-text-max-lines"]')) {
        functions.toggleTextMaxLines(target);
        evt.stopPropagation();
    }

    // Select all toggling
    if (evt.target.matches('.th__select-all')) {
        functions.toggleTableCheckboxes(mainTable);
    }
});

leftbarToggler.addEventListener('click', functions.toggleLeftbar);

fullscreenButtons.forEach((button) => {
    const fullscreenTarget = document.querySelector(button.dataset.targetSelector);

    button.addEventListener('click', () => functions.enterFullscreen(fullscreenTarget));
    fullscreenTarget.addEventListener('fullscreenchange', () => functions.toggleFullscreenClass(fullscreenTarget));
});

/*
|--------------------------------------------------------------------------
| Initializations
|--------------------------------------------------------------------------
*/

init();

function init() {}
