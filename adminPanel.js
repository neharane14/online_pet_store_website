document.addEventListener("DOMContentLoaded", () => {
    const dynamicContent = document.getElementById("dynamicContent");

    function loadContent(page) {
        fetch(page)
            .then(response => response.text())
            .then(data => {
                dynamicContent.innerHTML = data;
            })
            .catch(error => console.error("Error loading content:", error));
    }

    document.getElementById("managePets").addEventListener("click", (event) => {
        event.preventDefault();
        loadContent("managePets.php");
    });

    document.getElementById("manageUsers").addEventListener("click", (event) => {
        event.preventDefault();
        loadContent("manageUsers.php");
    });

    document.getElementById("manageOrders").addEventListener("click", (event) => {
        event.preventDefault();
        loadContent("manageOrders.php");
    });

    document.getElementById("contactus").addEventListener("click", (event) => {
        event.preventDefault();  // Prevents opening a new page
        loadContent("fetchFeedback.php"); // Loads the feedback page inside dynamicContent
    });
});
