document.addEventListener("DOMContentLoaded", () => {
    const decreaseButtons = document.querySelectorAll(".decrease");
    const increaseButtons = document.querySelectorAll(".increase");

    decreaseButtons.forEach(button => {
        button.addEventListener("click", () => updateQuantity(button, "decrease"));
    });

    increaseButtons.forEach(button => {
        button.addEventListener("click", () => updateQuantity(button, "increase"));
    });

    function updateQuantity(button, action) {
        const itemId = button.getAttribute("data-id");

        fetch(`cart.php?id=${itemId}&action=${action}`)
            .then(response => response.text())
            .then(() => {
                location.reload(); // Refresh the page to reflect updated quantity
            });
    }
});


