import { removeElementStylePropertyDelayed } from './utilities'

/*
|--------------------------------------------------------------------------
| Components helper functions
|--------------------------------------------------------------------------
*/

/**
 * Function to collapse an element with smooth transition.
 * @param {HTMLElement} element - The DOM element to collapse.
 */
function collapseElement(element) {
    element.style.height = element.scrollHeight + 'px';
    element.offsetHeight; // Force repaint
    element.style.height = '0px';
    removeElementStylePropertyDelayed(element, 'height', 300);
}

/**
 * Function to expand an element with smooth transition.
 * @param {HTMLElement} element - The DOM element to expand.
 */
function expandElement(element) {
    element.style.height = element.scrollHeight + 'px';
    removeElementStylePropertyDelayed(element, 'height', 300);
}

/*
|--------------------------------------------------------------------------
| Dropdown
|--------------------------------------------------------------------------
*/

function initDropdowns() {
    const dropdownButtons = document.querySelectorAll('.dropdown__button');

    dropdownButtons.forEach(button => {
        button.addEventListener('click', (evt) => {
            const dropdown = evt.currentTarget.closest('.dropdown');
            const isExpanded = button.getAttribute('aria-expanded') === 'true';

            dropdown.classList.toggle('dropdown--active');
            button.setAttribute('aria-expanded', !isExpanded);

            evt.stopPropagation();
        });
    });

    document.addEventListener('click', (evt) => {
        document.querySelectorAll('.dropdown--active').forEach(activeDropdown => {
            if (!activeDropdown.contains(evt.target)) {
                const button = activeDropdown.querySelector('.dropdown__button');
                activeDropdown.classList.remove('dropdown--active');
                button.setAttribute('aria-expanded', 'false');
            }
        });
    });
}

/*
|--------------------------------------------------------------------------
| Collapse
|--------------------------------------------------------------------------
*/

function initCollapsibles() {
    const togglers = document.querySelectorAll('[data-click-action="toggle-collapse"]');

    togglers.forEach(toggler => {
        toggler.addEventListener('click', () => {
            const collapse = document.querySelector(toggler.dataset.collapseSelector);
            const isOpen = collapse.classList.contains('collapse--open');

            if (!isOpen) {
                expandElement(collapse);
            } else {
                collapseElement(collapse);
            }

            collapse.classList.toggle('collapse--open');
        });
    });
}

/*
|--------------------------------------------------------------------------
| Accordion
|--------------------------------------------------------------------------
*/

function initAccordions() {
    const accordions = document.querySelectorAll('.accordion');

    accordions.forEach(accordion => {
        const buttons = accordion.querySelectorAll('.accordion__button');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const accordionItem = button.closest('.accordion__item');
                const accordionContent = accordionItem.querySelector('.accordion__content');
                const isOpen = accordionItem.classList.contains('accordion-item--open');

                accordion.querySelectorAll('.accordion-item--open').forEach(openItem => {
                    if (openItem !== accordionItem) {
                        const openContent = openItem.querySelector('.accordion__content');
                        collapseElement(openContent);
                        openItem.classList.remove('accordion-item--open');
                    }
                });

                if (!isOpen) {
                    expandElement(accordionContent);
                    accordionItem.classList.add('accordion-item--open');
                } else {
                    collapseElement(accordionContent);
                    accordionItem.classList.remove('accordion-item--open');
                }
            });
        });
    });
}

/*
|--------------------------------------------------------------------------
| Initialization
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', () => {
    initDropdowns();
    initCollapsibles();
    initAccordions();
});
