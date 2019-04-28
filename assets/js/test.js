$(document).ready(function(){

    $(".navbar-nav > li > a#upload").click(function(){

        let html = '';

        html += '<form id="formUpload" action="#" method="post" enctype="multipart/form-data">';
            html += '<input id="uploadPath" type="hidden" name="path" value="cloud/Ordner - 02">'
            html += '<input id="uploadFiles" type="file" name="files[]" multiple>';
            html += '<button type="submit" class="btn btn-primary">Upload</button>';
        html += "</form>";

        $("body").append(html);

    });

    $("body").on("submit", "#formUpload", function(e){

        e.preventDefault();

        let formData = new FormData(),
            files = document.getElementById("uploadFiles").files;

        for ( let i = 0; i < files.length; i++){
            formData.append("files[]", files[i]);
        };

        formData.append("path", document.getElementById("uploadPath").value);

        $.ajax({
            cache: false,
            contentType: false,
            data: formData,
            dataType: "json",
            method: "POST",
            processData: false,
            url: "api/upload",
            success: function(result){
                console.log(result);
            }
        });

    });

    /*$.ajax({
        url: "api/data/?mode=search&key=Datei-01.txt",
        dataType: "json",
        method: "GET",
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
    });*/

    // DELETE

    $.ajax({
        url: "api/data",
        data: {
            files: [
                {
                    name: "Datei-01.txt",
                    path: "cloud/Ordner - 02"
                },
                {
                    name: "Datei-04.txt",
                    path: "cloud/Ordner - 02"
                },
                {
                    name: "Datei-10.txt",
                    path: "cloud/Ordner - 02"
                }
            ]
        },
        dataType: "json",
        method: "DELETE",
        success: function(result){

            console.log(result);

        }
    });

});