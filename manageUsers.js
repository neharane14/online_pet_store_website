document.addEventListener("DOMContentLoaded", () => {
    const manageUsersButton = document.getElementById("manageUsers");
    const dynamicContent = document.getElementById("dynamicContent");

    manageUsersButton.addEventListener("click", (event) => {
        event.preventDefault();
        fetch("manageUsers.php")
            .then(response => response.text())
            .then(data => {
                dynamicContent.innerHTML = data;
            })
            .catch(error => console.error("Error loading users:", error));
    });
});
