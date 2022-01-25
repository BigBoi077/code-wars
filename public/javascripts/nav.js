$(function() {
    $(".menu-items a").each(function() {
        if (window.location.href.startsWith(this.href)) {
            $(this).addClass("selected");
        }
    });
});