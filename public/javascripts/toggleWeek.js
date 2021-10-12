

$("[data-toggle]").each(function (){
    this.addEventListener('click', (event) => {
        toggleWeek(this.dataset.toggle, $(this).find("i"))
        this.blur()
    })
})

function toggleWeek(weekData, i) {
    $("#weekExercises" + weekData).slideToggle();
    i.toggleClass("fa-chevron-right")
    i.toggleClass("fa-chevron-down")
}