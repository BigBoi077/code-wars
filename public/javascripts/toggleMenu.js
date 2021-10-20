
$("#hamburger-menu").click(
    function () {
        document.getElementById("bars").classList.toggle("hidden");
        document.getElementById("times").classList.toggle("hidden");
        document.getElementsByClassName("menu-items")[0].classList.toggle("active");
    }
)
