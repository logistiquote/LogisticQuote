document.addEventListener("DOMContentLoaded", function () {
    const navTabs = document.querySelector(".nav-tabs");
    const tabs = document.querySelectorAll('.nav-tabs > li a[title]');
    const nextButtons = document.querySelectorAll(".next-step");
    const prevButtons = document.querySelectorAll(".prev-step");

    // Initialize tooltips
    tabs.forEach(tab => {
        tab.setAttribute("data-bs-toggle", "tooltip");
        new bootstrap.Tooltip(tab);
    });

    // Handle tab clicks
    navTabs.addEventListener("click", function (e) {
        const clickedTab = e.target.closest("a[data-toggle='tab']");
        if (!clickedTab) return;

        const clickedLi = clickedTab.closest("li");
        if (clickedLi && clickedLi.classList.contains("disabled")) {
            e.preventDefault();
        }

        // Update active state
        document.querySelectorAll(".nav-tabs li").forEach(li => li.classList.remove("active"));
        if (clickedLi) clickedLi.classList.add("active");
    });

    // Next button click
    nextButtons.forEach(button => {
        button.addEventListener("click", function () {
            const activeLi = document.querySelector(".wizard .nav-tabs li.active");
            if (!activeLi) return;

            const nextLi = activeLi.nextElementSibling;
            if (nextLi && nextLi.classList.contains("disabled")) {
                nextLi.classList.remove("disabled");
            }

            if (nextLi) {
                const nextTab = nextLi.querySelector('a[data-toggle="tab"]');
                if (nextTab) nextTab.click();
            }
        });
    });

    // Previous button click
    prevButtons.forEach(button => {
        button.addEventListener("click", function () {
            const activeLi = document.querySelector(".wizard .nav-tabs li.active");
            if (!activeLi) return;

            const prevLi = activeLi.previousElementSibling;
            if (prevLi) {
                const prevTab = prevLi.querySelector('a[data-toggle="tab"]');
                if (prevTab) prevTab.click();
            }
        });
    });
});
