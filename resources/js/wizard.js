document.addEventListener("DOMContentLoaded", function () {
    const nextButtons = document.querySelectorAll(".next-step");
    const prevButtons = document.querySelectorAll(".prev-step");

    function showTab(tabId) {
        const tabLink = document.querySelector(`[href="${tabId}"]`);
        if (tabLink) {
            const tabEvent = new bootstrap.Tab(tabLink);
            tabEvent.show();
        }
    }

    nextButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const currentTab = document.querySelector(".tab-panel.active");
            const nextTab = currentTab.nextElementSibling;
            if (nextTab && nextTab.classList.contains("tab-panel")) {
                currentTab.classList.remove("active");
                nextTab.classList.add("active");
                showTab(`#${nextTab.id}`);
            }
        });
    });

    prevButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const currentTab = document.querySelector(".tab-panel.active");
            const prevTab = currentTab.previousElementSibling;
            if (prevTab && prevTab.classList.contains("tab-panel")) {
                currentTab.classList.remove("active");
                prevTab.classList.add("active");
                showTab(`#${prevTab.id}`);
            }
        });
    });
});
