document.addEventListener("DOMContentLoaded", function () {
    function fetchNotifications() {
        fetch('/notifications')
            .then(response => response.json())
            .then(data => {
                let notificationList = document.getElementById("notificationList");
                let notificationCount = document.getElementById("notificationCount");

                notificationList.innerHTML = "";

                if (data.length > 0) {
                    notificationCount.textContent = data.length;

                    data.forEach(notification => {
                        let item = document.createElement("li");
                        item.className = "dropdown-item notification-item";
                        item.innerHTML = `
                            <div class="notification-text">${notification.message}</div>
                            <button class="btn btn-sm btn-primary mark-read" data-id="${notification.id}">Mark as read</button>
<!--                            <div class="notification-text">${notification.message}<br><small>${notification.message}</small></div>-->
                        `;
                        notificationList.appendChild(item);
                    });

                    document.querySelectorAll(".mark-read").forEach(button => {
                        button.addEventListener("click", function () {
                            let notificationId = this.getAttribute("data-id");
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
        fetch(`/notifications/read/${notificationId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        })
            .then(() => fetchNotifications());
    }

    fetchNotifications();
    setInterval(fetchNotifications, 30000); // Refresh notifications every 30 seconds
});
