document.querySelectorAll('form').forEach((form) => {
    form.addEventListener('submit', function () {
        const spinner = document.querySelector('.spinner');
        spinner.classList.add('spinner--visible');
    });
});
