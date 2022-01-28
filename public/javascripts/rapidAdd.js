$(function () {
    var forValue = $("#for").val();
    $('#' + forValue).removeClass("hidden");
});

$("#for").on('change', function () {
    var forValue = $(this).val();
    console.log(forValue)
    $("#student").addClass("hidden");
    $("#team").addClass("hidden");
    console.log($('#' + forValue));
    $('#' + forValue).removeClass("hidden");
})