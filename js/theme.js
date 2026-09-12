function toggleTheme() {

    document.body.classList.toggle("dark-theme");

    const icon = document.getElementById("theme-icon");
    const text = document.getElementById("theme-text");

    if (document.body.classList.contains("dark-theme")) {

        if (icon) {
            icon.textContent = "☀";
        }

        if (text) {
            text.textContent = "Light Mode";
        }

        localStorage.setItem("theme", "dark");

    } else {

        if (icon) {
            icon.textContent = "☾";
        }

        if (text) {
            text.textContent = "Dark Mode";
        }

        localStorage.setItem("theme", "light");
    }
}


document.addEventListener("DOMContentLoaded", function () {

    const savedTheme = localStorage.getItem("theme");

    const icon = document.getElementById("theme-icon");
    const text = document.getElementById("theme-text");

    if (savedTheme === "dark") {

        document.body.classList.add("dark-theme");

        if (icon) {
            icon.textContent = "☀";
        }

        if (text) {
            text.textContent = "Light Mode";
        }

    } else {

        if (icon) {
            icon.textContent = "☾";
        }

        if (text) {
            text.textContent = "Dark Mode";
        }
    }

});