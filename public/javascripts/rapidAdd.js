$(function () {
    var forValue = $("#for").val();
    $('#' + forValue).removeClass("hidden");
});

$("#for").on('change', function () {
    var forValue = $(this).val();
    $("#student").addClass("hidden");
    $("#team").addClass("hidden");
    $('#' + forValue).removeClass("hidden");
})