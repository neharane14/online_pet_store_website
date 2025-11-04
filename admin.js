document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("loginForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent form submission

        // Get user input
        const username = document.getElementById("username").value.trim();
        const password = document.getElementById("password").value.trim();

        // Simple validation (you can replace this with a real authentication mechanism)
        if (username === "admin" && password === "admin123") {
            // Redirect to the admin panel
            window.location.href = "adminPanel.html";
        } else {
            alert("Invalid Username or Password");
        }
    });
});
