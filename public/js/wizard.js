/******/ (() => { // webpackBootstrap
/*!********************************!*\
  !*** ./resources/js/wizard.js ***!
  \********************************/
document.addEventListener("DOMContentLoaded", function () {
  var nextButtons = document.querySelectorAll(".next-step");
  var prevButtons = document.querySelectorAll(".prev-step");
  function showTab(tabId) {
    var tabLink = document.querySelector("[href=\"".concat(tabId, "\"]"));
    if (tabLink) {
      var tabEvent = new bootstrap.Tab(tabLink);
      tabEvent.show();
    }
  }
  nextButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      var currentTab = document.querySelector(".tab-panel.active");
      var nextTab = currentTab.nextElementSibling;
      if (nextTab && nextTab.classList.contains("tab-panel")) {
        currentTab.classList.remove("active");
        nextTab.classList.add("active");
        showTab("#".concat(nextTab.id));
      }
    });
  });
  prevButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      var currentTab = document.querySelector(".tab-panel.active");
      var prevTab = currentTab.previousElementSibling;
      if (prevTab && prevTab.classList.contains("tab-panel")) {
        currentTab.classList.remove("active");
        prevTab.classList.add("active");
        showTab("#".concat(prevTab.id));
      }
    });
  });
});
/******/ })()
;