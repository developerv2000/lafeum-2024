import axios from 'axios';

bootstrapPackages(); // Bootstrap packages immediately

window.addEventListener('load', () => {
    bootstrapComponents();
});

function bootstrapPackages() {
    // ********** Axios **********
    window.axios = axios;
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
}

function bootstrapComponents() {
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
}

