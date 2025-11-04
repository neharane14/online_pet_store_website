// Confirm deletion of pets
document.querySelectorAll('a[href*="delete_id"]').forEach(button => {
    button.addEventListener('click', function(event) {
        if (!confirm("Are you sure you want to delete this pet?")) {
            event.preventDefault();
        }
    });
});
