$(document).ready(function(){

    $(".navbar-nav > li > a#upload").click(function(){

        let html = '';

        html += '<form id="formUpload" action="#" method="post" enctype="multipart/form-data">';
            html += '<input type="file" name="filename[]" multiple>';
            html += '<button type="submit" class="btn btn-primary">Upload</button>';
        html += "</form>";

        $("body").append(html);

    });

    $("body").on("submit", "#formUpload", function(e){

        e.preventDefault();

        var formData = new FormData($(this)[0]);

        console.log(formData);

    });

    // GET

    /*$.ajax({
        url: "api/upload",
        dataType: "json",
        method: "POST",
        success: function(result){

            console.log(result);

        }
    });*/

    // CREATE

    /*$.ajax({
        url: "api/data",
        data: {
            name: "Ordner - 04",
            path: "cloud"
        },
        dataType: "json",
        method: "POST",
        success: function(result){

            console.log(result);

        }
    });

    // DELETE

    $.ajax({
        url: "api/data",
        data: {
            name: "Ordner - 04",
            path: "cloud"
        },
        dataType: "json",
        method: "DELETE",
        success: function(result){

            console.log(result);

        }
    });*/

});