/**
 * Function to remove a specific inline style property of an element after a certain duration.
 * @param {HTMLElement} element - The DOM element whose style property should be removed.
 * @param {string} property - The CSS property to remove (e.g., 'height', 'width').
 * @param {number} duration - The duration in milliseconds to wait before removing the property.
 */
function removeElementStylePropertyDelayed(element, property, duration) {
    setTimeout(() => {
        // Remove the specified inline style property from the element
        element.style[property] = '';
    }, duration);
}


// ********** Dropdown **********
// Handles the toggling of dropdown content visibility
document.querySelectorAll('.dropdown__button').forEach((button) => {
    button.addEventListener('click', (evt) => {
        const dropdown = evt.currentTarget.closest('.dropdown');
        const isExpanded = button.getAttribute('aria-expanded') === 'true';

        // Toggle active state
        dropdown.classList.toggle('dropdown--active');

        // Update aria-expanded attribute for accessibility
        button.setAttribute('aria-expanded', !isExpanded);

        // Stop event propagation to prevent the document click event from triggering
        evt.stopPropagation();
    });
});

// Hide dropdowns when clicking outside of them
document.addEventListener('click', (evt) => {
    document.querySelectorAll('.dropdown--active').forEach((activeDropdown) => {
        if (!activeDropdown.contains(evt.target)) {
            const button = activeDropdown.querySelector('.dropdown__button');

            // Remove active state
            activeDropdown.classList.remove('dropdown--active');

            // Update aria-expanded attribute
            button.setAttribute('aria-expanded', 'false');
        }
    });
});


// ********** Collapse **********
const collapseTogglers = document.querySelectorAll('[data-click-action="toggle-collapse"]');

collapseTogglers.forEach(toggler => {
    toggler.addEventListener('click', function () {
        const collapse = document.querySelector(toggler.dataset.collapseSelector);
        const isOpen = collapse.classList.contains('collapse--open');

        if (!isOpen) {
            // If not open, set the height to scrollHeight to expand
            collapse.style.height = collapse.scrollHeight + 'px';
        } else {
            // If open, prepare to collapse by setting the height to its current value
            collapse.style.height = collapse.scrollHeight + 'px';
            // Trigger reflow to ensure the transition happens
            collapse.offsetHeight; // Force a repaint
            // Set the height to 0px for smooth collapsing
            collapse.style.height = '0px';
        }

        collapse.classList.toggle('collapse--open');
        toggler.classList.toggle('collapse-button--active');

        // Remove the inline height style after the transition duration (300ms)
        removeElementStylePropertyDelayed(collapse, 'height', 300);
    });
});


// ********** Accordion **********
document.querySelectorAll('.accordion').forEach(accordion => {
    accordion.querySelectorAll('.accordion__button').forEach(button => {
        button.addEventListener('click', () => {
            const accordionItem = button.closest('.accordion__item');
            const accordionContent = accordionItem.querySelector('.accordion__content');
            const isOpen = accordionItem.classList.contains('accordion-item--open');

            // Collapse all open items within the same accordion except the current one
            accordion.querySelectorAll('.accordion-item--open').forEach(openItem => {
                if (openItem !== accordionItem) {
                    const openContent = openItem.querySelector('.accordion__content');
                    openContent.style.height = openContent.scrollHeight + 'px';
                    openContent.offsetHeight; // Force a repaint
                    openContent.style.height = '0px';
                    openItem.classList.remove('accordion-item--open');
                    removeElementStylePropertyDelayed(openContent, 'height', 300);
                }
            });

            if (!isOpen) {
                accordionContent.style.height = accordionContent.scrollHeight + 'px';
                accordionItem.classList.add('accordion-item--open');
            } else {
                accordionContent.style.height = accordionContent.scrollHeight + 'px';
                accordionContent.offsetHeight; // Force a repaint
                accordionContent.style.height = '0px';
                accordionItem.classList.remove('accordion-item--open');
            }

            removeElementStylePropertyDelayed(accordionContent, 'height', 300);
        });
    });
});
