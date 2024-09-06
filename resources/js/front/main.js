// Import necessary dependencies
import './bootstrap';
import { debounce } from '../global/utilities';

// DOM Elements
const scrollButtons = document.querySelector('.scroll-buttons');
const scrollTopBtn = document.querySelector('.scroll-buttons__top');
const scrollBottomBtn = document.querySelector('.scroll-buttons__bottom');
const spinner = document.querySelector('.spinner');

const likeForms = document.querySelectorAll('.like-form');
const favoriteForms = document.querySelectorAll('.favorite-form');

// Constants
const SCROLL_THRESHOLD = 300;

// Event Listeners
window.addEventListener('scroll', handleScroll);
scrollTopBtn.addEventListener('click', scrollTop);
scrollBottomBtn.addEventListener('click', scrollBottom);

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

// Functions
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

// Initializations (if needed)
init();

function init() {
    // Check scroll position on page load
    handleScroll();
}
