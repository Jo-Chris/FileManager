$(document).ready(function(){

    $.ajax({
        url: "api/data",
        data: {
            "name": "Ordner - 03",
            "path" : "cloud/Ordner - 01",
            "type": "folder"
        },
        dataType: "json",
        method: "POST",
        success: function(result){

            console.log(result);

        }
    });

});