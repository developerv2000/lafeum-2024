// Import necessary dependencies
import './bootstrap';
import { debounce } from '../global/utilities';

// DOM Elements
const scrollButtons = document.querySelector('.scroll-buttons');
const scrollTopBtn = document.querySelector('.scroll-buttons__top');
const scrollBottomBtn = document.querySelector('.scroll-buttons__bottom');
const spinner = document.querySelector('.spinner');

const likeForms = document.querySelectorAll('.like-form');

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

            likesCount.innerHTML = response.data.likesCount ?? '';
        })
        .finally(hideSpinner);
}

// Initializations (if needed)
init();

function init() {
    // Check scroll position on page load
    handleScroll();
}
