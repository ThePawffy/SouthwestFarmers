document.addEventListener("DOMContentLoaded", function () {
    const toggles = document.querySelectorAll(".custom-notification-toggle");

    toggles.forEach(function (toggle) {
        const wrapper = toggle.closest(".custom-notification-wrapper");
        const dropdown = wrapper.querySelector(".custom-notification-dropdown");

        toggle.addEventListener("click", function (e) {
            e.preventDefault();

            // Close other dropdowns
            document
                .querySelectorAll(".custom-notification-dropdown")
                .forEach((d) => {
                    if (d !== dropdown) d.classList.remove("show");
                });

            // Toggle this one
            dropdown.classList.toggle("show");
        });

        // Click outside to close
        document.addEventListener("click", function (e) {
            if (!wrapper.contains(e.target)) {
                dropdown.classList.remove("show");
            }
        });
    });
});
