$("[data-toggle]").each(function (){

    this.addEventListener('click', (event) => {
        toggleWeek(this.dataset.toggle, $(this).find("i"))
        this.blur()
    })
})

function toggleWeek(weekData, i) {
    $("#comment" + weekData).toggleClass('d-none');
    i.toggleClass("fa-chevron-up")
    i.toggleClass("fa-chevron-down")
}