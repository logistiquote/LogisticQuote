/******/ (() => { // webpackBootstrap
/*!********************************!*\
  !*** ./resources/js/wizard.js ***!
  \********************************/
document.addEventListener("DOMContentLoaded", function () {
  var wizardData = JSON.parse(sessionStorage.getItem("wizardData")) || {};
  function saveStepData(stepId) {
    var form = document.querySelector("#".concat(stepId));
    var inputs = form.querySelectorAll("input, textarea, select");
    inputs.forEach(function (input) {
      wizardData[input.name] = input.value;
    });
    sessionStorage.setItem("wizardData", JSON.stringify(wizardData));
  }
  function loadStepData(stepId) {
    var savedData = JSON.parse(sessionStorage.getItem("wizardData")) || {};
    var form = document.querySelector("#".concat(stepId));
    var inputs = form.querySelectorAll("input, textarea, select");
    inputs.forEach(function (input) {
      if (savedData[input.name]) {
        input.value = savedData[input.name];
      }
    });
  }
  function validateStep(stepId) {
    var form = document.querySelector("#".concat(stepId));
    var inputs = form.querySelectorAll("[required]");
    var isValid = true;
    inputs.forEach(function (input) {
      if (!input.value.trim()) {
        isValid = false;
        input.classList.add("is-invalid");
      } else {
        input.classList.remove("is-invalid");
      }
    });
    return isValid;
  }
  document.querySelectorAll(".next-step").forEach(function (button) {
    button.addEventListener("click", function () {
      var currentStep = button.closest(".tab-pane").id;
      if (!validateStep(currentStep)) {
        alert("Please fill in all required fields.");
        return;
      }
      saveStepData(currentStep);
      var activeLi = document.querySelector(".wizard .nav-tabs li.active");
      if (!activeLi) return;
      var nextLi = activeLi.nextElementSibling;
      if (nextLi) {
        var nextTab = nextLi.querySelector('a[data-toggle="tab"]');
        if (nextTab) nextTab.click();
        activeLi.classList.remove("active");
        nextLi.classList.add("active");
      }
    });
  });
  document.querySelectorAll(".prev-step").forEach(function (button) {
    button.addEventListener("click", function () {
      var currentStep = button.closest(".tab-pane").id;
      saveStepData(currentStep);
      var activeLi = document.querySelector(".wizard .nav-tabs li.active");
      if (!activeLi) return;
      var prevLi = activeLi.previousElementSibling;
      if (prevLi) {
        var prevTab = prevLi.querySelector('a[data-toggle="tab"]');
        if (prevTab) prevTab.click();
        activeLi.classList.remove("active");
        prevLi.classList.add("active");
      }
    });
  });
  document.querySelectorAll(".tab-pane").forEach(function (tabPane) {
    loadStepData(tabPane.id);
  });
});
/******/ })()
;