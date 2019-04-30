$(document).ready(function(){

    let files;

    // Upload new files/folder 
    $(".navbar-nav > li > a#upload").click(function(){

        bootbox.dialog({
            message: `<div class="top-level-container" data-toggle="modal" data-target="#myModal">
            <div class="modal-header" id="superimportantheader2">
            <h2 class="modal-title" id="myModalLabel">Datei hochladen</h2>
            </div>  
            <div class="modal-body">
                <p>Pfad: </p>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Home</li>
                    </ol>
                </nav>
                
                <div id="upload"></div>
                <div class="dropzone" id="dropzone">Hierher ziehen</div> 
                
            


            </div>
  
                </div>`,
            onEscape: true,
            backdrop: true,
            button: {
                label: 'Upload',
                className: 'btn btn-primary',
                callback: function(e){

                    console.log("Test");

                    e.preventDefault();
                
                    let formData = new FormData();
            
                    for ( let i = 0; i < files.length; i++){
                        formData.append("files[]", files[i]);
                    };
            
                    formData.append("path", document.getElementById("uploadPath").value);

                    console.log(formData);
            
                    /*$.ajax({
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
                    });*/

                    console.log("Test");

                }  
                
            }
        });

        var dropzone = document.getElementById("dropzone");

        dropzone.ondrop = function (e) {
            e.preventDefault();
            this.className = "dropzone";
            files = e.dataTransfer.files;
        };

        dropzone.ondragover = function(){
            this.className = "dropzone dragover";
            return false; 
        }

        dropzone.ondragleave = function(){
            this.className = "dropzone dragleave";
            return false;
        }

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
            message: `<div class="top-level-container">
            
            <div class="modal-header" id="superimportantheader">
            <h2 class="modal-title" id="myModalLabel">Ordner anlegen</h2>
          </div>
          <div class="modal-body">
            <p>Pfad: </p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">Home</li>
                </ol>
              </nav>

              <form>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Name</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Name des Ordners">
                  </div>
                </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
            <button type="button" class="btn btn-primary">Anlegen</button>
          </div>
            </div>`, 
            closeButton: true, 
            callback:function(e) {
                
                //Javscript Code heir (aber konzentrier die auf HTML oben)
            }
        })
    });
});