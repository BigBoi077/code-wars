
$("#exerciseUpload").change(function() {
    let file = $("#exerciseUpload").val().split("\\");
    $("#uploadLabel").html("Fichier Selectionné - " + file[2])
});