document.addEventListener("DOMContentLoaded", function () {
    const quantityInputs = document.querySelectorAll('.quantity-input');

    quantityInputs.forEach(function (input) {
        const plusButton = input.nextElementSibling;
        const minusButton = input.previousElementSibling;

        plusButton.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent default button behavior
            input.stepUp();
        });

        minusButton.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent default button behavior
            input.stepDown();
        });
    });
});