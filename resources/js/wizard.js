    document.addEventListener("DOMContentLoaded", function () {
    const wizardData = JSON.parse(sessionStorage.getItem("wizardData")) || {};

    function saveStepData(stepId) {
        const form = document.querySelector(`#${stepId}`);
        const inputs = form.querySelectorAll("input, textarea, select");
        inputs.forEach(input => {
            wizardData[input.name] = input.value;
        });

        sessionStorage.setItem("wizardData", JSON.stringify(wizardData));
    }

    function loadStepData(stepId) {
        const savedData = JSON.parse(sessionStorage.getItem("wizardData")) || {};
        const form = document.querySelector(`#${stepId}`);
        const inputs = form.querySelectorAll("input, textarea, select");
        inputs.forEach(input => {
            if (savedData[input.name]) {
                input.value = savedData[input.name];
            }
        });
    }

    function validateStep(stepId) {
        const form = document.querySelector(`#${stepId}`);
        const inputs = form.querySelectorAll("[required]");
        let isValid = true;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add("is-invalid");
            } else {
                input.classList.remove("is-invalid");
            }
        });

        return isValid;
    }

    document.querySelectorAll(".next-step").forEach(button => {
        button.addEventListener("click", function () {

            const currentStep = button.closest(".tab-pane").id;

            if (!validateStep(currentStep)) {
                alert("Please fill in all required fields.");
                return;
            }

            saveStepData(currentStep);

            const activeLi = document.querySelector(".wizard .nav-tabs li.active");
            if (!activeLi) return;

            const nextLi = activeLi.nextElementSibling;

            if (nextLi) {
                const nextTab = nextLi.querySelector('a[data-toggle="tab"]');
                if (nextTab) nextTab.click();
                activeLi.classList.remove("active");
                nextLi.classList.add("active");
            }
        });
    });

    document.querySelectorAll(".prev-step").forEach(button => {
        button.addEventListener("click", function () {
            const currentStep = button.closest(".tab-pane").id;
            saveStepData(currentStep);

            const activeLi = document.querySelector(".wizard .nav-tabs li.active");
            if (!activeLi) return;
            const prevLi = activeLi.previousElementSibling;

            if (prevLi) {
                const prevTab = prevLi.querySelector('a[data-toggle="tab"]');
                if (prevTab) prevTab.click();
                activeLi.classList.remove("active");
                prevLi.classList.add("active");
            }
        });
    });

    document.querySelectorAll(".tab-pane").forEach(tabPane => {
        loadStepData(tabPane.id);
    });
});

