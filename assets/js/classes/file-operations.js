$(document).ready(function(){

    // Upload new files/folder 
    $(".navbar-nav > li > a#upload").click(function(){

        bootbox.dialog({
            title: 'Upload Menu',
            message: `<form id="formUpload" action="#" method="post" enctype="multipart/form-data">
            <input id="uploadPath" type="hidden" name="path" value="Ordner A">
            <input id="uploadFiles" type="file" name="files[]" multiple>
            <button type="submit" class="btn btn-primary">Upload</button> </form>`,

            size: "large",
            onEscape: false,
            backdrop: true,
            button: {
                upload: {
                    label: 'Upload',
                    className: 'btn btn-primary',
                    callback: function(e){
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
                    }
                }
            }
        });

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

    //Create new dialog
    document.getElementById('new').addEventListener('click', function() {
        console.log('click');
        //UI vom Max hier rein...
        //platzhalter code
        bootbox.dialog({ 
            message: '<div class="text-center"><i class="fa fa-spin fa-spinner"></i> Dieses Feature steht in Kürze zur Verfügung...</div>', 
            closeButton: true, 
            callback:function(e) {
                
                //wird ausgeführt, wenn button clicked
            }
        })
    });
});