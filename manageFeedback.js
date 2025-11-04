document.addEventListener("DOMContentLoaded", function () {
    fetch("fetchFeedback.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("dynamicContent").innerHTML = data;
        })
        .catch(error => console.error("Error fetching feedback:", error));
});
