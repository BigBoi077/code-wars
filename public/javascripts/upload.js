
$("#exerciseUpload").change(function() {
    let file = $("#exerciseUpload").val().split("\\");
    $("#uploadLabel").html("Fichier Selectionné - " + file[2]);
    $("#exercice-submit").prop("disabled", false);
    $(".mission-upload").removeClass("disabled");
});