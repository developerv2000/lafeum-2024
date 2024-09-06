// Import necessary dependencies
import './bootstrap';
import { debounce, removeElementStylePropertyDelayed } from '../global/utilities';

// DOM Elements
const scrollButtons = document.querySelector('.scroll-buttons');
const scrollTopBtn = document.querySelector('.scroll-buttons__top');
const scrollBottomBtn = document.querySelector('.scroll-buttons__bottom');
const spinner = document.querySelector('.spinner');

const likeForms = document.querySelectorAll('.like-form');
const favoriteForms = document.querySelectorAll('.favorite-form');
const expandMoreButtons = document.querySelectorAll('.expand-more__button');

// Style variables
const rootStyles = getComputedStyle(document.documentElement);
const defaultCardCollapsedTextMaxHeight = rootStyles.getPropertyValue('--default-card-collapsed-text-max-height').trim();

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

expandMoreButtons.forEach((button) => {
    button.addEventListener('click', function (event) {
        handleExpandMoreTogglings(event);
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

// Initializations (if needed)
init();

function init() {
    // Check scroll position on page load
    handleScroll();
    removeRedundantExpandMoreButtons();
}
