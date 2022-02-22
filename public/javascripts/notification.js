/* (function () {
    const da = document.querySelector("[data-user-da]").dataset.userDa;
    const route = `/notification/connect/${da}`;
    const evtSource = new EventSource(route);

    evtSource.onmessage = function(e) {
        const notifications = e.data;
        const notificationDiv = document.querySelector("[data-notifications]");
        if (notificationDiv !== undefined) {
            for (const notification in notifications) {
                if (notification.id !== undefined) {
                    if (!notificationExists(notification.id)) {
                        notificationDiv.append(createNotificationNode(notification));
                    }
                }
            }
        }
    };
})(); */

/* function notificationExists(id) {
    return document.getElementById(`notification-${id}`) !== undefined;
}

function createNotificationNode(notification) {
    const isHidden = notification.is_seen ? "hidden" : "";
    const div = document.createElement('div');
    div.innerHTML = `
        <div class="card mb-3 mr-4" id=notification-"${notification.id}">
          <div class="row p-3">
            <div class="w-100 px-2">
              <div class="d-flex justify-content-between">
                <h4 class="mb-1">${notification.name}</h4>
                <a class="notification-check ${isHidden}" href="/notification/seen/${notification.id}"">
                  <i class="fas fa-check-circle" />
                </a>
              </div>
              <p class="py-1 pt-2">${notification.description}</p>
              <h6 class="mb-0 pt-2">Émis le ${notification.date}</h6>
            </div>
          </div>
        </div>`;
    return div;
} */