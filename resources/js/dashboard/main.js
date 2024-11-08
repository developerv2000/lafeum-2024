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

/*
|--------------------------------------------------------------------------
| Event Listeners
|--------------------------------------------------------------------------
*/

mainTable.addEventListener('click', (evt) => {
    const target = evt.target;

    // Delegate text max lines toggling
    if (target.closest('[data-on-click="toggle-td-text-max-lines"]')) {
        functions.toggleTextMaxLines(target);
    }
});

leftbarToggler.addEventListener('click', functions.toggleLeftbar);

/*
|--------------------------------------------------------------------------
| Initializations
|--------------------------------------------------------------------------
*/

init();

function init() {}
