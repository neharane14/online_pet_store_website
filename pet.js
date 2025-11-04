
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('pet1').addEventListener('click', function() {
            window.location.href = 'dogGallery.php';
        });

        document.getElementById('pet2').addEventListener('click', function() {
            window.location.href = 'catGallery.php';
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        function updateCartCounter() {
            fetch("cartCounter.php")
                .then(response => response.text())
                .then(count => {
                    let cartCounter = document.querySelector(".cart-counter");
                    cartCounter.textContent = count;
                    cartCounter.style.display = count > 0 ? "flex" : "none";
                })
                .catch(error => console.error("Error fetching cart count:", error));
        }
    
        updateCartCounter(); // Update counter on page load
    });
    