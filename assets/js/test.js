$(document).ready(function(){

    $.ajax({
        url: "api/data",
        data: {
            "name": "Ordner - 012",
            "path" : "cloud"
        },
        dataType: "json",
        method: "DELETE",
        success: function(result){

            console.log(result);

        }
    });

});