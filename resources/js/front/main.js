/*
|--------------------------------------------------------------------------
| Necessary dependencies
|--------------------------------------------------------------------------
*/

import './bootstrap';
import { debounce, removeElementStylePropertyDelayed } from '../global/utilities';

/*
|--------------------------------------------------------------------------
| Constants
|--------------------------------------------------------------------------
*/

const SCROLL_THRESHOLD = 300;
const TERMS_POPUP_MARGIN_TOP = 32;
const GET_VOCABULARY_BODY_URL = '/vocabulary/get-body'

/*
|--------------------------------------------------------------------------
| DOM Elements
|--------------------------------------------------------------------------
*/

// Spinner
const spinner = document.querySelector('.spinner');
const spinnableForms = document.querySelectorAll('[data-on-submit="show-spinner"]');

// Scroll buttons
const scrollButtons = document.querySelector('.scroll-buttons');
const scrollTopBtn = document.querySelector('.scroll-buttons__top');
const scrollBottomBtn = document.querySelector('.scroll-buttons__bottom');

// Card components
const likeForms = document.querySelectorAll('.like-form');
const favoriteForms = document.querySelectorAll('.favorite-form');
const expandMoreButtons = document.querySelectorAll('.expand-more__button');
const termCardsBodyLinks = document.querySelectorAll('.terms-card__body-text a');
const vocabularyList = document.querySelector('.vocabulary-list');

// Modal buttons
const showModalButtons = document.querySelectorAll('[data-click-action="show-modal"]');
const hideActiveModalButtons = document.querySelectorAll('[data-click-action="hide-active-modals"]');
const showVideoModalButtons = document.querySelectorAll('[data-click-action="show-youtube-video-modal"]');
const showPhotoModalButtons = document.querySelectorAll('[data-click-action="show-photos-modal"]');
const renameFolderButtons = document.querySelectorAll('[data-click-action="rename-folder"]');
const destroyFolderButtons = document.querySelectorAll('[data-click-action="destroy-folder"]');

// Modals and components
const youtubeVideoModal = document.querySelector('.youtube-video-modal');
const youtubeVideoModalIframeWrapper = youtubeVideoModal.querySelector('.youtube-video-modal__iframe-wrapper');
const youtubeVideoModalTitle = youtubeVideoModal.querySelector('.modal__title');

const photosModal = document.querySelector('.photos-modal');
const photosModalImage = photosModal.querySelector('.photos-modal__image');
const photosModalDesc = photosModal.querySelector('.photos-modal__desc');

const renameFolderModal = document.querySelector('.rename-folder-modal');
const renameFolderIdInput = renameFolderModal.querySelector('input[name="id"]');
const renameFolderNameInput = renameFolderModal.querySelector('input[name="name"]');

const destroyFolderModal = document.querySelector('.destroy-folder-modal');
const destroyFolderIdInput = destroyFolderModal.querySelector('input[name="id"]');

// Style variables
const rootStyles = getComputedStyle(document.documentElement);
const defaultCardCollapsedTextMaxHeight = rootStyles.getPropertyValue('--default-card-collapsed-text-max-height').trim();

// Update ava form elements
const updateAvaForm = document.querySelector('.update-ava-form');
const updateAvaInput = document.querySelector('.update-ava-form__input');

// Feedback form elements
const feedbackForm = document.querySelector('.feedback-form');
const recaptchaToken = document.querySelector('#recaptcha_token');

/*
|--------------------------------------------------------------------------
| Event Listeners
|--------------------------------------------------------------------------
*/

spinnableForms.forEach((form) => {
    form.addEventListener('submit', showSpinner);
});

window.addEventListener('scroll', handleScroll);
scrollTopBtn.addEventListener('click', scrollTop);
scrollBottomBtn.addEventListener('click', scrollBottom);

showModalButtons.forEach((button) => {
    button.addEventListener('click', (evt) => {
        hideAllActiveModals();
        showModal(document.querySelector(evt.currentTarget.dataset.modalSelector));
    });
});

hideActiveModalButtons.forEach((button) => {
    button.addEventListener('click', hideAllActiveModals);
});

updateAvaInput?.addEventListener('change', handleUpdateAvaInputChange);

feedbackForm?.addEventListener('submit', handleFeedbackFormSubmit);

// Initialize modals
showVideoModalButtons.forEach((button) => {
    button.addEventListener('click', function (evt) {
        const title = evt.currentTarget.dataset.videoTitle;
        const src = evt.currentTarget.dataset.videoSrc;

        showYoutubeVideoModal(title, src);
    });
});

showPhotoModalButtons.forEach((button) => {
    button.addEventListener('click', function (evt) {
        const src = evt.currentTarget.dataset.photoSrc;
        const desc = evt.currentTarget.dataset.photoDesc;

        showPhotosModal(src, desc);
    });
});

renameFolderButtons.forEach((button) => {
    button.addEventListener('click', function (evt) {
        const folderId = evt.currentTarget.dataset.folderId;
        const folderName = evt.currentTarget.dataset.folderName;

        showRenameFolderModal(folderId, folderName);
    });
});

destroyFolderButtons.forEach((button) => {
    button.addEventListener('click', function (evt) {
        const folderId = evt.currentTarget.dataset.folderId;
        destroyRenameFolderModal(folderId);
    });
});

// Initialize local search functionality
document.querySelectorAll('input[data-action="local-search"]').forEach((input) => {
    input.addEventListener('input', debounce(handleLocalSearch));
});

// Initialize like forms
likeForms.forEach((form) => {
    form.addEventListener('submit', function (event) {
        handleLikeToggling(event);
    });
});

favoriteForms.forEach((form) => {
    form.addEventListener('submit', function (event) {
        handleFavoriteRefreshing(event);
    });
});

expandMoreButtons.forEach((button) => {
    button.addEventListener('click', function (event) {
        handleExpandMoreTogglings(event);
    });
});

/**
 * Adds event listeners to each link in `termCardsBodyLinks` for displaying and hiding popups.
 */
termCardsBodyLinks.forEach((link) => {
    // Create a URL object from the link's href attribute
    const url = new URL(link.href);
    const hostname = url.hostname;

    // Check if the link's href is not empty and the hostname matches 'lafeum.ru'
    if (link.href !== '' && hostname === 'lafeum.ru') {
        // Add a 'mouseover' event listener to display the popup when the link is hovered over
        link.addEventListener('mouseover', function (event) {
            displayTermCardsPopupOnLinkHover(event);
        });

        // Add a 'mouseleave' event listener to hide the popup when the mouse leaves the link
        link.addEventListener('mouseleave', function (event) {
            hideAllTermCardPopupsOnBlur();
        });
    }
});

vocabularyList?.addEventListener('mouseover', (evt) => {
    handleVocabularyListHover(evt);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
*/

function handleFeedbackFormSubmit(evt) {
    evt.preventDefault();

    grecaptcha.ready(function() {
        grecaptcha.execute('6LeTtHcpAAAAANDcYSO5J8Kbpd6tYjERQ4-vocAG', { action: 'submit' }).then(function(token) {
            // Add the generated reCAPTCHA token to the hidden input field
            recaptchaToken.value = token;

            // Once reCAPTCHA is validated, submit the form programmatically
            feedbackForm.submit();
        });
    });
}

function handleScroll() {
    const isScrolledPastThreshold = window.scrollY > SCROLL_THRESHOLD;
    toggleScrollButtonsVisibility(isScrolledPastThreshold);
}

function toggleScrollButtonsVisibility(isVisible) {
    scrollButtons.classList.toggle('scroll-buttons--visible', isVisible);
}

function scrollTop() {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
}

function scrollBottom() {
    window.scrollTo({
        top: document.body.scrollHeight,
        behavior: "smooth",
    });
}

function showSpinner() {
    spinner.classList.add('spinner--visible');
}

function hideSpinner() {
    spinner.classList.remove('spinner--visible');
}

function showModal(modal) {
    modal.classList.add('modal--visible');
}

function hideModal(modal) {
    modal.classList.remove('modal--visible');
}

function hideAllActiveModals() {
    document.querySelectorAll('.modal--visible').forEach(hideModal);
    removeIframeFromYoutubeVideoModal(); // remove iframe to stop video from playing in background
}

/**
 * Handles the local search input event, filtering elements based on the input's value.
 * @param {Event} evt - The input event triggered when the user types in the search input.
 */
function handleLocalSearch(evt) {
    const keyword = evt.target.value.toLowerCase();
    const selector = evt.target.dataset.targetSelector;

    document.querySelectorAll(selector).forEach((item) => {
        const itemText = item.textContent || item.innerText;
        item.style.display = itemText.toLowerCase().includes(keyword) ? '' : 'none';
    });
}

function handleLikeToggling(event) {
    event.preventDefault();
    showSpinner();

    const form = event.target;
    const likeContainer = form.closest('.like-container');
    const likeIcon = likeContainer.querySelector('.like-container__icon');
    const likesCount = likeContainer.querySelector('.like-container__counter');

    axios.post(form.action, {}, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            if (response.data.isLiked) {
                likeIcon.classList.add('like-container__icon--liked');
            } else {
                likeIcon.classList.remove('like-container__icon--liked');
            }

            likesCount.innerHTML = response.data.likesCount;
        })
        .finally(hideSpinner);
}

function handleFavoriteRefreshing(event) {
    event.preventDefault();
    showSpinner();

    const form = event.target;
    const favoriteDropdown = form.closest('.favorite-dropdown');
    const favoriteIcon = favoriteDropdown.querySelector('.favorite-dropdown__icon');

    // Collect checked folder ids
    const folderIDs = [];
    form.querySelectorAll('input[name="folder_ids[]"]:checked').forEach((chb) => {
        folderIDs.push(chb.value);
    });

    axios.post(form.action, { folder_ids: folderIDs }, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            if (response.data.isFavorited) {
                favoriteIcon.classList.add('favorite-dropdown__icon--favorited');
            } else {
                favoriteIcon.classList.remove('favorite-dropdown__icon--favorited');
            }
        })
        .finally(hideSpinner);
}

function handleExpandMoreTogglings(event) {
    const button = event.currentTarget;
    const expandMore = button.closest('.expand-more');
    const cardBody = button.closest('.default-card__body');
    const cardText = cardBody.querySelector('.default-card__body-text');
    const isExpanded = cardText.classList.contains('default-card__body-text--expanded');

    if (!isExpanded) {
        // If not expanded, set the max-height to scrollHeight to expand
        cardText.style.maxHeight = cardText.scrollHeight + 'px';
    } else {
        // If expanded, prepare to collapse by setting the height to its current value
        cardText.style.maxHeight = cardText.scrollHeight + 'px';
        // Trigger reflow to ensure the transition happens
        cardText.offsetHeight; // Force a repaint
        // Set the max-height to default height for smooth collapsing
        cardText.style.maxHeight = defaultCardCollapsedTextMaxHeight;
    }

    cardText.classList.toggle('default-card__body-text--expanded');
    expandMore.classList.toggle('expand-more--expanded');

    // Remove the inline height style after the transition duration (300ms)
    removeElementStylePropertyDelayed(cardText, 'maxHeight', 300);
}

function removeRedundantExpandMoreButtons() {
    expandMoreButtons.forEach((button) => {
        const container = button.closest('.expand-more');
        const cardBody = button.closest('.default-card__body');
        const cardText = cardBody.querySelector('.default-card__body-text');

        const isOverflowed = cardText.scrollHeight > cardText.clientHeight;

        if (!isOverflowed) {
            container.remove();
        }
    });
}

function displayTermCardsPopupOnLinkHover(evt) {
    const link = evt.currentTarget;
    const url = new URL(link.href);

    const card = link.closest('.terms-card');
    const popup = card.querySelector('.terms-card__popup');
    const popupInner = card.querySelector('.terms-card__popup-inner');

    // Extract term ID from the URL pathname (expected format: /term/{id})
    const id = url.pathname.slice(6);
    link.dataset.subtermId = id; // Store the term ID in the link's dataset

    // Update the popup content only if the term ID has changed
    if (popupInner.dataset.currentSubtermId !== link.dataset.subtermId) {
        popupInner.dataset.currentSubtermId = link.dataset.subtermId;
        popupInner.innerHTML = window.subterms[link.dataset.subtermId];
        popup.style.top = `${link.offsetTop + TERMS_POPUP_MARGIN_TOP}px`;
    }

    popup.classList.add('terms-card__popup--visible');
}

function hideAllTermCardPopupsOnBlur() {
    document.querySelectorAll('.terms-card__popup--visible').forEach((popup) => {
        popup.classList.remove('terms-card__popup--visible');
    });
}

function handleVocabularyListHover(evt) {
    const targ = evt.target;

    const isLink = targ.classList.contains('vocabulary-list__link');
    const contentAlreadyLoaded = targ.dataset.contentLoaded;

    if (isLink && contentAlreadyLoaded != 1) {
        loadVocabularyLinkContent(targ);
    }
}

function loadVocabularyLinkContent(link) {
    const popup = link.nextElementSibling;
    const termId = link.dataset.termId;

    axios.post(GET_VOCABULARY_BODY_URL, { term_id: termId }, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            popup.innerHTML = '<div class="vocabulary-list__popup-inner">' + response.data + '</div>';
        });

    link.dataset.contentLoaded = 1;
}

/**
 * Displays the YouTube video modal with the given title and video source URL.
 * Clears any existing iframe content, sets the modal title, and adds the new video iframe.
 * @param {string} title - The title of the video.
 * @param {string} src - The source URL of the YouTube video.
 */
function showYoutubeVideoModal(title, src) {
    removeIframeFromYoutubeVideoModal();
    youtubeVideoModalTitle.innerHTML = title;

    const iframe = document.createElement('iframe');
    iframe.src = src;
    iframe.allow = "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture";
    iframe.setAttribute('allowfullscreen', '');
    iframe.setAttribute('allowscriptaccess', 'always');
    youtubeVideoModalIframeWrapper.appendChild(iframe);

    showModal(youtubeVideoModal);
}

// Used on hiding youtube video modal and changing youtube iframe video
function removeIframeFromYoutubeVideoModal() {
    youtubeVideoModalIframeWrapper.innerHTML = null;
}

function showPhotosModal(src, desc) {
    photosModalImage.src = src;
    photosModalDesc.innerHTML = desc;

    showModal(photosModal);
}

function showRenameFolderModal(folderId, folderName) {
    renameFolderIdInput.value = folderId;
    renameFolderNameInput.value = folderName;

    showModal(renameFolderModal);
}

function destroyRenameFolderModal(folderId) {
    destroyFolderIdInput.value = folderId;
    showModal(destroyFolderModal);
}

function handleUpdateAvaInputChange(evt) {
    evt.preventDefault();
    showSpinner();

    const file = evt.target.files?.[0];

    if (file) {
        updateAvaForm.submit();
    } else {
        hideSpinner();
    }
}

/**
 * Registers a Service Worker for Progressive Web Apps (PWA).
 * This function checks if the browser supports Service Workers and, if so, registers
 * a Service Worker script located at the root of the site. It logs the registration
 * status to the console.
 */
function registerServiceWorker() {
    if ('serviceWorker' in navigator) {
        // Register the Service Worker script located at the root of the site
        navigator.serviceWorker.register(`${document.location.origin}/service-worker.js`)
            .then(function (registration) {
                console.log('Service worker registration succeeded:', registration);
            })
            .catch(function (error) {
                console.log('Service worker registration failed:', error);
            });
    } else {
        console.log('Service workers are not supported.');
    }
}

/*
|--------------------------------------------------------------------------
| Initializations
|--------------------------------------------------------------------------
*/

init();

function init() {
    handleScroll(); // Check scroll position on page load
    removeRedundantExpandMoreButtons();
}

window.addEventListener('load', function () {
    registerServiceWorker();
});
