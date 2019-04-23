$(document).ready(function(){

    $.ajax({
        url: "api/data",
        data: {
            "name": "Ordner - 01",
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