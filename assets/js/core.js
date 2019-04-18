$(document).ready(function(){

    $.ajax({
        url: "api/data",
        dataType: "json",
        method: "GET",
        success: function(result){
            console.log(result);
        }
    });

});