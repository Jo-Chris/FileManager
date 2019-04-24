
// guess we should use a pattern here, or use a better approach avoiding globals
//get the current path you're in
let currentPath = '';
//retrieve the current folder content (for deleting)
let currentFolderContent = [];

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

    // Click events
    document.getElementById('tree-container').addEventListener('click', clickFn);
    document.getElementById('tbody-table').addEventListener('click', removeSingleItem);

    //show folder content
    function clickFn(e){
        if(e.target.classList.contains('directory')){
            //fetch api with current folder
            const data = loadDirectory(e.target.getAttribute("data-path"))
            .then(res => showDirectoryData(res.data));
        }
    }

    //this directory needs to get the path of the folder
    async function loadDirectory(directory){
        const res = await fetch(`api/data/?directory=${directory}`)    //api/data?direc

        console.log("Will do a fetch for directory: " + directory);
       
        const data = await res.json();

        return data;
    }

    /**
     * (1) Display the content of the current Folder
     * @param {*} directoryData - loads the data from a specific directory and displays it in the table 
     */
    function showDirectoryData(directoryData){        
        //clear current view
        document.querySelector('tbody').innerHTML='';
        //get the length
        let id = document.querySelector('tbody').rows.length;

        directoryData.forEach(data => {
            const newRow = document.createElement('tr');

            newRow.innerHTML = 
            `<tr class="dynRow" data-id="${id++}">
                <td><input type="checkbox" value="1" name="filedata" class="form-control"></input></td>
                <td>${data.name}</td>
                <td>${data.size}</td>
                <td>${formatDate(new Date())}</td>
                <td class="pull-right"> <button class="btn btn-danger pull-right deleteItem"> Löschen </button> </td>
            </tr>
            `;

            //append the row
            document.querySelector('tbody').append(newRow);       
            //update the foldercontent
            updateFolderContent();    
        });
    }

    /**
     * 
     * @param {*} e the element that should be removed
     */
    function removeSingleItem(e) {
        if(e.target.classList.contains('deleteItem')){
            e.target.parentNode.parentNode.remove();
        }
    }

    /**
     * @param {*} date - the date given by the background formatted 
     */
    function formatDate(date){
        let month = date.getMonth();
        month = month < 10 ? `0${month+1}` : month+1;

        return `${date.getDate()}/${month}/${date.getFullYear()} um ${date.getHours()}:${date.getMinutes()}`;
    }

    function updateFolderContent(){
        let folderContent = document.getElementsByName('tr');

        folderContent.forEach((el) => {
            console.log("Arrays" + el);
        });
    }
});


