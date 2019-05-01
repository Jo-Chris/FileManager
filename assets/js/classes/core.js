//create new Utils
const utils = new Utils();
//bad approach, bad smell (saves the currentTable as array after every fetch)
let globalArrayVal = [];
//for deleting items
let mainPath = [];
let mainPathString = "";

/*********************************************************************************
 *            T R E E  S T R U C T U R E     &   F E T C H I N G                 *
 *********************************************************************************/

//at application start, fetch data
setUpTreeStructure();
//show the folder at application start
loadDirectory('cloud')
.then(res => showDirectoryData(res.data));

/**
 * @returns a data-obj containing fetched data
 */
async function fetchCloudData(){
    const res = await fetch('api/data');

    const data = await res.json();
    return data;
}

/**
 * create tree structure
 */
function setUpTreeStructure(){
    //fetch data from cloud
    fetchCloudData()
        .then(res => {
            let html = `<ul>`;
                    html += createTreeView(res.data);
                html += `</ul>`;
            document.getElementById('tree-container').innerHTML = html;

            $('#tree-container > ul').filetree({
                collapsed: true
            });
        });
}

/**
 * fill tree with data
 */
function createTreeView(data){
    let html = ``;

    data.forEach((el) => {

        if (el.type === "folder"){

            let hasDirectory = false,
                subItems = 0;

            if (el.items.length >= 1 ) {

                for (let i = 0; i < el.items.length; i++) {
                    if (el.items[i].type === "folder") {
                        hasDirectory = true;

                    };
                    subItems++;
                };

            };

            html += `<li><a class="directory" href="#" data-path="${el.path}">${el.name}<span class="badge badge-pill badge-primary float-right">${subItems}</span></a>`;

            if (hasDirectory){
                html +=`<ul>`
                    html += createTreeView(el.items);
                html +=`</ul>`;
            };

            html += `</li>`;

        };

    });

    return html;

}

/*********************************************************************************
 *                      D O M   M A N I P U L A T I O N                          *
 *********************************************************************************/

// Click events
document.getElementById('tbody-table').addEventListener('click', removeSingleItem);
document.getElementById('tbody-table').addEventListener('click', showBottomButtonActionGroup);
document.getElementById('maincol').addEventListener('click', removeAllItems);
document.getElementById('searchbar').addEventListener('keyup', searchForFiles);
document.getElementById('select-all').addEventListener('click', selectAll);
document.getElementById('de-select-all').addEventListener('click', deSelectAll);
document.getElementById('reverse-selection').addEventListener('click', reverseSelection);
document.getElementById('global-search').addEventListener('keyup', showSearchResults);
document.getElementById('tbody-table').addEventListener('click', download);
document.getElementById('button-action-container').addEventListener('click', downloadMultiple);
document.getElementById('new').addEventListener('click', newFolder);
document.getElementById('upload').addEventListener('click', uploadFile);
document.getElementById('tbody-table').addEventListener('click', folderNavigation);

//this directory needs to get the path of the folder
async function loadDirectory(directory){
    const res = await fetch(`api/data/?directory=${directory}`)    //api/data?direc

    const data = await res.json();

    if(!directory){
        //after fetch is done and folders appear, show the searchbar and current path-value
        showPathAndSearchbar(directory);
    }
    //this var references the current path 
    mainPath = directory.split("/");
    mainPathString = directory;

    return data;
}

function showPathAndSearchbar(path){
   //show the container (path-value + searchbar)
   document.getElementById('seachbar-path-container').style.display = "inline-flex";
   //set the value of the current folder
   document.getElementById('path-value').textContent = path;
}

/**
 * Display the content of the current Folder if its not a folder, put it in. if its a folder, put it at the very top
 * @param {*} directoryData - loads the data from a specific directory and displays it in the table
 */
function showDirectoryData(directoryData){
    //clear current view
    document.querySelector('tbody').innerHTML='';
    //get the length
    
    if(directoryData !== undefined){

        //make table visible
        document.getElementById('main-table').classList.remove('invisible')

        directoryData.forEach(data => {
            //If the element is a folder, the next method will handle it by putting it to the top
            if(data.type !== 'folder'){
                //push the data to the globalArrayVal
                globalArrayVal.push(data);
                
                const newRow = document.createElement('tr');
                //set class of new rom
                newRow.classList = "dynRow"
                newRow.setAttribute("data-type", data.type);
                newRow.setAttribute("data-path", data.path);
                newRow.innerHTML = displayTableData(data);

                //append the row
                document.querySelector('tbody').appendChild(newRow);

                //if fetch was successful, show the action-buttons
                showBottomActions();
            }
        });

        //now if theres a folder... move it to the top
        directoryData.reverse().forEach(data => {
            if(data.type === 'folder'){
                 //create tr element
                const newRow = document.createElement('tr');
                //create the path attribute
                newRow.setAttribute("data-path", data.path);
                newRow.setAttribute("data-type", data.type);
                //fill the arry
                newRow.innerHTML = displayTableData(data, true);

                //now insert that row at the very top
                const firstRow = document.querySelector('tbody').firstChild;
                //insert it at the very top
                
                document.querySelector('tbody').insertBefore(newRow, firstRow);
            }
        });
    }
}

/**
 * subFolder navigation
 * @param {*} e the element that should be navigated to
 */
function folderNavigation(e){
    //get attr
    let attr = e.target.parentNode.getAttribute('data-type');
    //if equal to folder, load content
    if(attr === 'folder'){
        let newPath = e.target.parentNode.getAttribute('data-path');
        console.log(newPath);
        loadDirectory(newPath)
        .then(res => showDirectoryData(res.data));
    }
}

/**
 * @param {*} e the element that should be removed
 */
function removeSingleItem(e) {

    let deleteArr = [];

    if(e.target.classList.contains('deleteItem')){
        bootbox.confirm('Sind sie sicher?', (res) => {
            if(!res){
                return;
            }else{

                let file = {};
                //get name and path
                file.name = e.target.parentNode.parentNode.parentNode.children[0].lastChild.textContent;
                //current path is always displayed at top
                file.path = e.target.parentNode.parentNode.parentNode.getAttribute('data-path');
                //create an array containing the name and the path of the element to be deleted
                deleteArr.push(file);
                
                console.log(e.target.parentNode.parentNode);

                // Delete from UI 
                e.target.parentNode.parentNode.remove();
                
                // Delete from DB
                deleteData(deleteArr);

            }
        });
    };
}

function removeAllItems(e){

    const checkboxes = document.querySelector('tbody').querySelectorAll('[type="checkbox"]');
    //delete arr
    let deleteArr = [];

    if(e.target.classList.contains('clear-table')){
        bootbox.confirm('Sind sie sicher?', (res) => {
            if(!res){
                return;
            }else{
                checkboxes.forEach((el)=>{
                    if(el.checked){
                        //get the name of the current file

                        let file = {};
                        file.name = el.parentNode.lastChild.textContent;
                        //current path is always displayed at top
                        file.path = el.parentElement.parentElement.getAttribute('data-path');
                        //create array of elements to be deleted
                        deleteArr.push(file);
                        //Delete from UI
                        el.parentNode.parentNode.remove();
                    }
                });

                //this array contains all items that should be deleted
                //delete from DB
                //we've still got an bug here!! 
                deleteDate(deleteArr)
                    .then()
                    .catch();
            }
        });
    }
}

/**
 * Delete fetch request
 * @param {*} data - the data to be deleted
 */
function deleteData(data){

    return new Promise((res, rej) => {
        fetch('api/data', {
            method: 'DELETE',
            headers: {
                'Content-type' : 'application/json'
            },
            body: "files=" + JSON.stringify(data)
        })
            .then(res => res.json())
            .then(res => {

                // Reload tree structure

                setUpTreeStructure();

            })
            .catch(err => rej(err))
    });
}

/**
 * @param {*} files - array containing name and path property
 */
function download(e){
    //Check for a "single-item-download" --> button next to the file
    if(e.target.classList.contains('downloadItem')){
            let files = [];
            files.push({
                name: e.target.parentNode.parentNode.parentNode.childNodes[1].lastChild.textContent,
                path: e.target.parentNode.parentNode.parentNode.getAttribute('data-path')
            });
            
            /**@todo exception handling! */
            window.location.href = rootUrl + "/api/download/?files=" + JSON.stringify(files);
    }
}

function downloadMultiple(e){
    //Check for a multiple-download (bottom Action group)

    if(e.target.classList.contains('download-items')){
        //length of elements
        const checkboxes = document.querySelector('tbody').querySelectorAll('[type="checkbox"]');

        let arr = [];

        for (let i = 0; i < checkboxes.length; i++){
            arr.push({
               name: checkboxes[i].parentNode.lastChild.textContent,
               path: checkboxes[i].parentNode.parentNode.getAttribute('data-path')
        });

        //after everything is ready, get those files
        window.location.href = rootUrl + "/api/download/?files=" + JSON.stringify(arr);
        }
    }
}

/**
 * If more than 2 checkboxed are checked, a further actionDialog appears
 * enabling the user to remove these elements or (transfer them into another folder or do sth else )
 * @param {*} e
 */
function showBottomButtonActionGroup(){
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
        showBottomButtons(true);
    }else{
        showBottomButtons(false);
    }
}

/**
 * Transfers the table data into an array and return it
 * @todo for backend
 * @deprecated - dont use this anymore
 */
function getTableAsArray(){
    let tableData = document.getElementById('tbody-table');
    let arr = [];

    for (let i = 0; i < tableData.rows.length; i++){
        arr.push({
            name: tableData.rows[i].cells[0].textContent,
            size: tableData.rows[i].cells[1].textContent,
            lastModified: tableData.rows[i].cells[3].textContent
        });
    }
    return arr;
}


/**
 * This function is based on a indexOf comparison and filters through the array
 * @todo saving the tableData into an global array is... well, shit
 * @todo the algorithm for searching items needs an overhaul 
 */
function searchForFiles(){
    /**
     * i know this is duplicate code.. but we get the raw data, then calculate the bits and bytes and the last modified date 
     * and that data gets saved.. so either this way or fetching the data again, which is bad
     */
    if (document.querySelector('#searchbar').value == ''){
        globalArrayVal.forEach(data => {
            //create new row
            const newRow = document.createElement('tr');
            //create id (for what?)
            let id = document.querySelector('tbody').rows.length;

            newRow.innerHTML = displayTableData(data);

            //append the row
            document.querySelector('tbody').append(newRow);
        });
    }
    //clear current view
    document.querySelector('tbody').innerHTML='';

    let enteredText = document.querySelector('#searchbar').value;

    globalArrayVal.forEach((data) => {
        
    if(!data.name.toLowerCase().contains(enteredText)){
        const newRow = document.createElement('tr');

        let id = document.querySelector('tbody').rows.length;

        newRow.innerHTML = newRow.innerHTML = displayTableData(data);
        
        //append the row
        document.querySelector('tbody').append(newRow);
    }
    });
}

/**
 * async fetch function - fetch data from api (userSearch input)
 * @returns data promise
 */
async function globalSearch(){
    let searchVal = document.getElementById('global-search').value;

    if(searchVal === ''){
        document.getElementById('tbody-table').innerHTML = '';
        //if the searchbar is empty, show the latest visited folder
        //showDirectoryData(globalArrayVal);
        return;
    }

    const res = await fetch(`api/data/?mode=search&key=${searchVal}`)    //api/data?direc

    //globalPathVar = `${directory}`;
    
    const data = await res.json();

    return data;
}
/**
 * handel promise from @function globalSearch and fill the table with data
 */
function showSearchResults(){
    globalSearch()
        .then(res => {
            //fill table with searched data
            showDirectoryData(res.data)
        })
        .catch(err => {
            return; //no search provided, so nothing should happen
        });
}

/**
 * 
 * @param {*} data - data to be displayed in the table
 */
function displayTableData(data, bool){

    let id = document.querySelector('tbody').rows.length;

    return `
            <td class="table-light align-middle"><input type="checkbox" class=" ${bool ? "invisible" : "visible" } name="filedata" ></input><button class="btn mr-2 ml-2"><i class="${utils.determineFileIcon(data.name, data.type)} fa-2x text-primary"></i></button>${data.name}</td>
            <td class="table-light align-middle">${utils.calcRealSize(data.size)}</td>
            <td class="table-light align-middle">${utils.formatDate(data.date_modified)}</td>
            <td class="table-light text-center align-middle"> 
            <button class="btn btn-outline-danger ml-2 float-right deleteItem">Löschen</button>
            <button class="btn btn-outline-primary float-right downloadItem ${bool ? "invisible" : "visible" }">Herunterladen</button></td>
            </tr>
            `;
}


function newFolder(){

    let breadcrumb = "";

    for (let i = 0; i < mainPath.length; i++){
        breadcrumb += "<li class='breadcrumb-item' aria-current='page'>" + mainPath[i] + "</li>";
    };

    bootbox.dialog({
        message: `
        <div class="top-level-container">
            <div class="modal-header" id="superimportantheader">
                <h2 class="modal-title" id="myModalLabel">Ordner anlegen</h2>
            </div>
            <div class="modal-body">
                <p class="m-0">Pfad: </p>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-white p-0">` + breadcrumb + `</ol>
                </nav>
                <form>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Name</label>
                        <input type="text" class="form-control" id="createFolder" placeholder="Name des Ordners" required>
                    </div>
                </form>
            </div>
        </div>`,
        closeButton: true,
        buttons: {
            //cancel button
            cancel: {
                label: "Abbrechen",
                className: "btn btn-outline-danger",
                callback: function(e){}
            },
            create: {
                label: "Anlegen",
                className: "btn btn-primary",
                callback: function (e) {

                    e.preventDefault();

                    $.ajax({
                        url: "api/data",
                        data: {
                            name: document.getElementById("createFolder").value,
                            path: mainPathString
                        },
                        dataType: "json",
                        method: "POST",
                        success: function(result){

                            // Reload tree structure

                            setUpTreeStructure();

                            // Reload directories and files

                            loadDirectory(mainPathString).then(res => showDirectoryData(res.data));

                        }
                    });

                }
            }
        }
    });
}

function uploadFile(){

    let breadcrumb = "",
        files = [];

    for (let i = 0; i < mainPath.length; i++){
        breadcrumb += "<li class='breadcrumb-item' aria-current='page'>" + mainPath[i] + "</li>";
    };

    $("body").on("drag dragstart dragend dragover dragenter dragleave drop", ".uploadBox", function(e){
        e.preventDefault();
        e.stopPropagation();
    }).on("dragover dragenter", ".uploadBox", function(){
        $(".uploadBox").addClass("is-dragover");
        $(".uploadBox").removeClass("is-dragged");
    }).on("dragleave dragend drop", ".uploadBox", function(){
        $(".uploadBox").removeClass("is-dragover");
    }).on("drop", ".uploadBox", function(e){
        files = e.originalEvent.dataTransfer.files;
        $(".uploadBox").addClass("is-dropped");
        $(".uploadBox label.dropped span.number").text("(" + files.length + ")");
    });

    bootbox.dialog({
        message: `
        <div class="top-level-container" data-toggle="modal" data-target="#myModal">
            <div class="modal-header" id="superimportantheader2">
                <h2 class="modal-title" id="myModalLabel">Datei hochladen</h2>
            </div>  
            <div class="modal-body">
                <p class="m-0">Pfad: </p>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-white p-0">` + breadcrumb + `</ol>
                </nav>
                <form class="uploadBox" method="post" action="" enctype="multipart/form-data">
                    <div class="box-input">
                        <svg class="box-icon" xmlns="http://www.w3.org/2000/svg" width="50" height="43" viewBox="0 0 50 43"><path d="M48.4 26.5c-.9 0-1.7.7-1.7 1.7v11.6h-43.3v-11.6c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v13.2c0 .9.7 1.7 1.7 1.7h46.7c.9 0 1.7-.7 1.7-1.7v-13.2c0-1-.7-1.7-1.7-1.7zm-24.5 6.1c.3.3.8.5 1.2.5.4 0 .9-.2 1.2-.5l10-11.6c.7-.7.7-1.7 0-2.4s-1.7-.7-2.4 0l-7.1 8.3v-25.3c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v25.3l-7.1-8.3c-.7-.7-1.7-.7-2.4 0s-.7 1.7 0 2.4l10 11.6z"></path></svg>
                        <input class="box-file" type="file" name="files[]" id="file" data-multiple-caption="{count} Datei(en) ausgewählt" multiple />
                        <label class="default" for="file">
                            <strong>Datei auswählen</strong>
                            <span class="box-dragndrop"> oder per Drag & Drop einfügen</span>.
                        </label>
                        <label class="dropped" for="file">
                            <span class="box-dragndrop"><span class="number"></span> Dateien ausgewählt</span>
                        </label>
                      </div>
                    </div>
                </form>
            </div>
        </div>`,
        onEscape: true,
        backdrop: true,
        buttons: {
            cancel: {
                label: "Abbrechen",
                className: "btn btn-outline-danger",
                callback: function(e){}
            },
            upload: {
                label: "Upload",
                className: "btn btn-primary",
                callback: function(e){

                    e.preventDefault();

                    let formData = new FormData();

                    if (files){
                        for (let i = 0; i < files.length; i++){
                            formData.append("files[]", files[i]);
                        };
                    };

                    formData.append("path", mainPathString);

                    $.ajax({
                        cache: false,
                        contentType: false,
                        data: formData,
                        dataType: "json",
                        method: "POST",
                        processData: false,
                        url: "api/upload",
                        success: function(result){

                            // Reload tree structure

                            setUpTreeStructure();

                            // Reload directories and files

                            loadDirectory(mainPathString).then(res => showDirectoryData(res.data));

                        }
                    });

                }
            }
        }
    });

} 


/**
 * @param {*} bool - true: show Bottom buttons, false: hide bottomButtons
 */
function showBottomButtons(bool){
    if(bool){
        document.querySelector('#down-remove-btn').classList.remove('invisible');
        document.querySelector('#down-download-btn').classList.remove('invisible');
    }else{
        document.querySelector('#down-remove-btn').classList.remove('visible');
        document.querySelector('#down-remove-btn').classList.add('invisible');
        document.querySelector('#down-remove-btn').classList.remove('visible');
        document.querySelector('#down-download-btn').classList.add('invisible');
    }
}

function showBottomActions(){
    document.getElementById('button-action-container').style.display = 'block';
}

function selectAll(){
    const checkboxes = document.querySelector('tbody').querySelectorAll('[type="checkbox"]');
    checkboxes.forEach((el) => {
        el.checked = true;
    });

    showBottomButtonActionGroup();
}

function deSelectAll(){
    const checkboxes = document.querySelector('tbody').querySelectorAll('[type="checkbox"]');
    checkboxes.forEach((el) => {
        el.checked = false;
    });

    showBottomButtonActionGroup();
}

function reverseSelection(){
    const checkboxes = document.querySelector('tbody').querySelectorAll('[type="checkbox"]');
    checkboxes.forEach((el) => {
        el.checked ? el.checked = false : el.checked = true;
    });

    showBottomButtonActionGroup();
}