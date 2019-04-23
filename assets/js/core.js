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

    // Click event tree view
    document.getElementById('tree-container').addEventListener('click', clickFn);

    function clickFn(e){
        if(e.target.classList.contains('directory')){
            //something is broken with the first "directory" --> others work

            //fetch api with current folder
            loadDirectory(e.target.innerHTML)
            .then(res => console.log(res));
        }
    }

    async function loadDirectory(directory){

        const res = await fetch('api/data')

        console.log("Will do a fetch for directory: " + directory);
       
        const data = await res.json();

        return data;
    }
});