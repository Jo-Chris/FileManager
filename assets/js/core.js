// guess we should use a pattern here, or use a better approach avoiding globals
// get the current path you're in
let globalPathVar = [];

//bad approach, bad smell (saves the currentTable as array after every fetch)
let globalArrayVal = '';

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
    document.getElementById('tbody-table').addEventListener('click', showDetails);
    document.getElementById('maincol').addEventListener('click', clearTable);
    document.getElementById('searchbar').addEventListener('keyup', searchForFiles);

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

        console.log("fetching... " + directory);
        globalPathVar = `api/data/?directory=${directory}`;
        
        const data = await res.json();

        //setGlobalPath

        return data;
    }

    /**
     * Display the content of the current Folder
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
                <td class="table-light align-middle"><input type="checkbox" value="1" name="filedata" class="form-control checkbox"></input></td>
                <td class="table-light"><button class="btn mr-2"><i class="fas fa-${determineFileIcon(data.name)} fa-3x"></i></button>${data.name}</td>
                <td class="table-light">${data.size}</td>
                <td class="table-light">${formatDate(new Date())}</td>
                <td class="table-light" align-right"> <button class="btn btn-danger float-right deleteItem"> Löschen </button> </td>
            </tr>
            `;

            //append the row
            document.querySelector('tbody').append(newRow);       
        });

        //DELETE LATER --> bad smell
        globalArrayVal = getTableAsArray();
        //get global
        console.log(setGlobalPath(globalPathVar));
    }

    /**
     * @param {*} e the element that should be removed
     */
    function removeSingleItem(e) {

        /**
         * @todo add the confirmation dialog here, maybe with bootstrap module
         */

        if(e.target.classList.contains('deleteItem')){
            e.target.parentNode.parentNode.remove();
        }
    };

    function clearTable(e){
        const checkboxes = document.querySelector('tbody').querySelectorAll('[type="checkbox"]');

        if(e.target.classList.contains('clear-table')){
            console.log('hit');
            checkboxes.forEach((el)=>{
                if(el.checked){
                    el.parentNode.parentNode.remove();
                }
                //if removing is done, hideDetails again
                hideDetails();
            });
        }
    }

    /**
     * If more than 2 checkboxed are checked, a further actionDialog appears
     * enabling the user to remove these elements or (transfer them into another folder or do sth else )
     * @param {*} e 
     */
    function showDetails(e){    
        const checkboxes = document.querySelector('tbody').querySelectorAll('[type="checkbox"]');
        
        //every checkbox enabled increases the counter by 1
        let cbCounter = 0;
        for (let i = 0; i < checkboxes.length; i++){
            if(checkboxes[i].checked){
                cbCounter++;
            }
        }
        //if greater than 2, show action Dialog
        if(cbCounter >= 2){
            if(e.target.classList.contains('checkbox')){
                document.getElementById('selectedAction').style.display = 'block';            
            }
        }else{
            hideDetails();
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

    /**
     * hide the action-dialog
     */
    function hideDetails(){
        document.getElementById('selectedAction').style.display = 'none'; 
    }

    /**
     * Transfers the table data into an array and return it
     * @todo for backend 
     */
    function getTableAsArray(){
        let tableData = document.getElementById('tbody-table');
        let arr = [];
        for (let i = 0; i < tableData.rows.length; i++){
            arr.push({
                name: tableData.rows[i].cells[1].textContent,
                size: tableData.rows[i].cells[2].innerHTML,
                lastModified: tableData.rows[i].cells[3].innerHTML
            });
        }

        console.log(arr);

        return arr;
    }
    /**
     * 
     * @param {*} filename get the filename and return the appropriate icon
     */
    function determineFileIcon(filename){
        let fileending = filename.split('.')[1];
        let iconClass = 'file-alt' //looks good as a standard icon
        
        //check if some major files are within
        if(fileending === 'docx') iconClass = 'file-word';
        if(fileending === 'png' || fileending === 'jpg' || fileending === 'jpeg' || fileending == 'gif' ) iconClass = 'file-image';
        if(fileending === 'ppx') iconClass = 'file-powerpoint';
        if(fileending === 'xls') iconClass = 'file-excel';
        if(fileending === 'csv') iconClass = 'file-csv';

        return iconClass;
    }

    /**
     * This function is based on a indexOf comparison and filters through the array
     * @todo saving the tableData into an global array is... well, shit
     */
    function searchForFiles(){
        //if the user removes all entered chars, get the old stuff back in 
         showDirectoryData(globalArrayVal);
         //clear current view
         document.querySelector('tbody').innerHTML='';
         //get the length
         let id = document.querySelector('tbody').rows.length;
         // currentTabledata is currently global... so just access it this way now, we'll find 
         // a better way later
         let tableData = globalArrayVal;
         let enteredText = document.querySelector('#searchbar').value;

         tableData.forEach((data) => {
            if(!data.name.toLowerCase().indexOf(enteredText)){
                const newRow = document.createElement('tr');

                newRow.innerHTML = 
                `<tr class="dynRow" data-id="${id++}">
                    <td class="table-light align-middle"><input type="checkbox" value="1" name="filedata" class="form-control checkbox" ></input></td>
                    <td class="table-light"> <button class="btn mr-2"> <i class="fas fa-${determineFileIcon(data.name)} fa-3x"></i> </button>${data.name}</td>
                    <td class="table-light">${data.size}</td>
                    <td class="table-light">${formatDate(new Date())}</td>
                    <td class="table-light" align-right"> <button class="btn btn-danger float-right deleteItem"> Löschen </button> </td>
                </tr>
                `;

                //append the row
                document.querySelector('tbody').append(newRow);     
            }  
         });
    }

    function setGlobalPath(path){
        tempArr = [];
        paths = path.split('/');
        paths.forEach((el)=>{
           tempArr.push(el); 
        });

        return tempArr;
    }
});


