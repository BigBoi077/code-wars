(function () {
    const da = document.querySelector("[data-user-da]");
    const route = `/notification/connect/${da}`;
    const evtSource = new EventSource(route);

    evtSource.onmessage = function(e) {
        console.log(e);
    }
})();