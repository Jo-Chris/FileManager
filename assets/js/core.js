$(document).ready(function(){

    const overview = new Overview();

    // Load all directories for tree view

    $.ajax({
        url: "api/data",
        dataType: "json",
        method: "GET",
        success: function(result){

            // Write tree view

            if (result.data.length > 0){
                $(".leftcolumn > div ").append(overview.writeTreeView(result.data));
            };

        }
    });

});