// Get the cart counter element
const cartCounter = document.querySelector('.cart-counter');

// Function to update the cart counter from localStorage
function updateCartCount() {
    const cartCount = localStorage.getItem('cartCount') || 0; // Default to 0 if not set
    cartCounter.textContent = cartCount;
    cartCounter.style.display = cartCount > 0 ? 'flex' : 'none'; // Show only if count > 0
}

// Function to add an item to the cart
function addToCart() {
    let cartCount = parseInt(localStorage.getItem('cartCount')) || 0;
    cartCount += 1;
    localStorage.setItem('cartCount', cartCount);
    updateCartCount();
}

// Initialize cart counter on page load
document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
});
