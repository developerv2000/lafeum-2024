// Spinner
document.querySelectorAll('form').forEach((form) => {
    form.addEventListener('submit', function () {
        const spinner = document.querySelector('.spinner');
        spinner.classList.add('spinner--visible');
    });
});

// Recaptcha
document.querySelector('.form--with-recaptcha')?.addEventListener('submit', function (event) {
    event.preventDefault();

    grecaptcha.ready(function () {
        grecaptcha.execute('6LeTtHcpAAAAANDcYSO5J8Kbpd6tYjERQ4-vocAG', { action: 'submit' }).then(function (token) {
            // Add the generated reCAPTCHA token to the hidden input field
            document.querySelector('#recaptcha_token').value = token;

            // Once reCAPTCHA is validated, submit the form programmatically
            event.target.submit();
        });
    });
});
