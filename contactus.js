document.addEventListener('DOMContentLoaded', function() {
    // Select all input fields and textareas
    var inputs = document.querySelectorAll('input, textarea');
    
    // Loop through each input and apply lowercase transformation
    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            this.value = this.value.toLowerCase();
        });
    });
});



document.addEventListener("DOMContentLoaded", function () {
    function capitalizeFirstLetter(input) {
        input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1);
    }

    document.getElementById("name").addEventListener("input", function () {
        capitalizeFirstLetter(this);
    });

    document.getElementById("email").addEventListener("input", function () {
        this.value = this.value.toLowerCase(); // Ensures email remains lowercase
    });

    document.getElementById("mess").addEventListener("input", function () {
        capitalizeFirstLetter(this);
    });

    let mobileInput = document.getElementById("mobile");
    
    // Create an error message element and place it below the input
    let mobileError = document.createElement("div");
    mobileError.style.color = "red";
    mobileError.style.fontSize = "14px";
    mobileError.style.marginTop = "5px"; // Space between input and error message
    mobileError.style.display = "none"; // Initially hidden
    mobileInput.insertAdjacentElement("afterend", mobileError);

    mobileInput.addEventListener("input", function () {
        this.value = this.value.replace(/\D/g, ""); // Allow only numbers

        if (this.value.length !== 10) {
            mobileError.textContent = "Mobile number must be exactly 10 digits.";
            mobileError.style.display = "block";
        } else {
            mobileError.style.display = "none";
        }
    });

    document.getElementById("contact-form").addEventListener("submit", function (event) {
        capitalizeFirstLetter(document.getElementById("name"));
        capitalizeFirstLetter(document.getElementById("mess"));

        if (mobileInput.value.length !== 10) {
            mobileError.textContent = "Mobile number must be exactly 10 digits.";
            mobileError.style.display = "block";
            event.preventDefault(); // Stop form submission
        }
    });
});


