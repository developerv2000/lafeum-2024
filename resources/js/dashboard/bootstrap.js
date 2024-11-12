/*
|--------------------------------------------------------------------------
| Necessary dependencies
|--------------------------------------------------------------------------
*/

import axios from 'axios';
import '../../custom-components/script';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/*
|--------------------------------------------------------------------------
| Initialization Functions
|--------------------------------------------------------------------------
*/

const SELECTIZE_CLASSES = {
    SINGLE: '.single-selectize:not(.manually-initializable-selectize):not(.linked-selectize)',
    LINKED: '.linked-selectize:not(.manually-initializable-selectize)',
    MULTIPLE: '.multiple-selectize:not(.manually-initializable-selectize)',
    MULTIPLE_TAGGABLE: '.multiple-taggable-selectize:not(.manually-initializable-selectize)',
};

/**
 * Initializes the selectize components based on class selectors.
 */
function initializeSelectizes() {
    // Single Selectize
    $(SELECTIZE_CLASSES.SINGLE).selectize({
        plugins: ["auto_position", "preserve_on_blur"],
    });

    // Linked Selectize
    $(SELECTIZE_CLASSES.LINKED).selectize({
        plugins: ["auto_position"],
        onChange(value) {
            window.location = value;
        },
    });

    // Multiple Selectize
    $(SELECTIZE_CLASSES.MULTIPLE).selectize({
        plugins: ["auto_position", "preserve_on_blur"],
    });

    // Multiple Taggable Selectize
    $(SELECTIZE_CLASSES.MULTIPLE_TAGGABLE).selectize({
        plugins: ["auto_position"],
        create(input, callback) {
            callback({
                value: input,
                text: input,
            });
        },
        createOnBlur: true,
    });
}

/**
 * Initializes Simditor editors based on class selectors.
 */
function initializeSimditors() {
    Simditor.locale = 'ru-RU';

    const simpleToolbar = ['title', 'bold', 'italic', 'underline', 'color', '|', 'ol', 'ul', 'blockquote', 'code', 'table', '|', 'link', 'hr', '|', 'indent', 'outdent', 'alignment'];
    const imageToolbar = [...simpleToolbar, 'image'];

    const simditorConfigs = {
        toolbarFloatOffset: '60px',
        toolbar: simpleToolbar,
        imageButton: 'upload',
    };

    document.querySelectorAll('.simditor').forEach(textarea => {
        new Simditor({ ...simditorConfigs, textarea });
    });

    document.querySelectorAll('.imaged-simditor').forEach(textarea => {
        new Simditor({
            ...simditorConfigs,
            textarea,
            toolbar: imageToolbar,
            upload: {
                url: '/simditor/upload-image',
                fileKey: 'image',
                connectionCount: 10,
                leaveConfirm: 'Пожалуйста дождитесь окончания загрузки изображений на сервер! Вы уверены что хотите закрыть страницу?',
            },
            defaultImage: '/img/dashboard/simditor-default-image.png',
        });
    });
}

/*
|--------------------------------------------------------------------------
| Initializations
|--------------------------------------------------------------------------
*/

/**
 * Initializes all components.
 */
function init() {
    initializeSelectizes();
    initializeSimditors();
}

init();
