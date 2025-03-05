/******/ (() => { // webpackBootstrap
/*!***************************************!*\
  !*** ./resources/js/notifications.js ***!
  \***************************************/
document.addEventListener("DOMContentLoaded", function () {
  function fetchNotifications() {
    fetch('/notifications').then(function (response) {
      return response.json();
    }).then(function (data) {
      var notificationList = document.getElementById("notificationList");
      var notificationCount = document.getElementById("notificationCount");
      notificationList.innerHTML = "";
      if (data.length > 0) {
        notificationCount.textContent = data.length;
        data.forEach(function (notification) {
          var item = document.createElement("li");
          item.className = "dropdown-item notification-item";
          item.innerHTML = "\n                            <div class=\"notification-text\">".concat(notification.message, "</div>\n                            <button class=\"btn btn-sm btn-primary mark-read\" data-id=\"").concat(notification.id, "\">Mark as read</button>\n<!--                            <div class=\"notification-text\">").concat(notification.message, "<br><small>").concat(notification.message, "</small></div>-->\n                        ");
          notificationList.appendChild(item);
        });
        document.querySelectorAll(".mark-read").forEach(function (button) {
          button.addEventListener("click", function () {
            var notificationId = this.getAttribute("data-id");
            markAsRead(notificationId);
          });
        });
      } else {
        notificationList.innerHTML = '<li class="dropdown-item text-center no-notifications">No notifications</li>';
        notificationCount.textContent = "0";
      }
    });
  }
  function markAsRead(notificationId) {
    fetch("/notifications/read/".concat(notificationId), {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({})
    }).then(function () {
      return fetchNotifications();
    });
  }
  fetchNotifications();
  setInterval(fetchNotifications, 30000); // Refresh notifications every 30 seconds
});
/******/ })()
;