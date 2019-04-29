// guess we should use a pattern here, or use a better approach avoiding globals
// get the current path you're in
let globalPathVar = [];

//bad approach, bad smell (saves the currentTable as array after every fetch)
let globalArrayVal = [];

//for deleting items
let mainPath = '';



/*********************************************************************************
 *            T R E E  S T R U C T U R E     &   F E T C H I N G                 *
 *********************************************************************************/

//at application start, fetch data
setUpTreeStructure();

/**
 * @returns a data-obj containing fetched data
 */
async function fetchCloudData(){
    const res = await fetch('api/data');

    console.log('feching order structure');

    const data = await res.json();
    //console.log(data);
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

//this directory needs to get the path of the folder
async function loadDirectory(directory){
    const res = await fetch(`api/data/?directory=${directory}`)    //api/data?direc

    console.log("fetching... " + directory);
    globalPathVar = `${directory}`;

    const data = await res.json();

    if(!directory){
        //after fetch is done and folders appear, show the searchbar and current path-value
        showPathAndSearchbar(directory);
        showFolderIsEmpty();
    }
    //this var references the current path 
    mainPath = directory;

    return data;
}

function showPathAndSearchbar(path){
   //show the container (path-value + searchbar)
   document.getElementById('seachbar-path-container').style.display = "inline-flex";
   //set the value of the current folder
   document.getElementById('path-value').textContent = path;
}

/**
 * Display the content of the current Folder
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
            console.log(data);
            //push the data to the globalArrayVal
            globalArrayVal.push(data);
            const newRow = document.createElement('tr');

            newRow.innerHTML = displayTableData(data);

            //append the row
            document.querySelector('tbody').append(newRow);

            //if fetch was successful, show the action-buttons
            showBottomActions();
        });
    }
}

/**
 * @param {*} e the element that should be removed
 */
function removeSingleItem(e) {

    if(e.target.classList.contains('deleteItem')){
        bootbox.confirm('Sind sie sicher?', (res) =>{
            if(!res){
                return;
            }else{
                //get name and path
                let name = e.target.parentNode.parentNode.children[0].lastChild.textContent;
                //current path is always displayed at top
                let path = mainPath;
                //create an array containing the name and the path of the element to be deleted
                let arr = [];
                arr.push(createDelteJSONArray(name, path));
                
                // Delete from UI 
                e.target.parentNode.parentNode.remove();
                
                // Delete from DB

            }
        });
    };
}

function removeAllItems(e){

    const checkboxes = document.querySelector('tbody').querySelectorAll('[type="checkbox"]');
    //delete arr
    let deleteArr = [];

    if(e.target.classList.contains('clear-table')){
        bootbox.confirm('Sind sie sicher?', (res) =>{
            if(!res){
                return;
            }else{
                checkboxes.forEach((el)=>{
                    if(el.checked){
                        //get the name of the current file
                        let name = el.parentNode.lastChild.textContent;
                        //current path is always displayed at top
                        let path = mainPath;

                        console.log(deleteArr.push(createDelteJSONArray(name, path)));
                        //Delete from UI
                        el.parentNode.parentNode.remove();
                    }
                });

                //this array contains all items that should be deleted
                console.log(deleteArr);
            }
        });
    }
}

/**
 * @param {*} files - array containing name and path property
 */
function download(e){
   
    //Check for a "single-item-download" --> button next to the file
    if(e.target.classList.contains('downloadItem')){
        let name = e.target.parentNode.parentNode.childNodes[1].lastChild.textContent;
        let path = mainPath;
        let files = [];
        files.push({
            name: name,
            path: path
        });
        
        /**@todo exception handling! */
        window.location.href = "/filemanager/api/download/?files=" + JSON.stringify(files);

        return res;
    }
}

function downloadMultiple(e){
    //Check for a multiple-download (bottom Action group)

    if(e.target.classList.contains('download-items')){
            
        console.log('hit');
        /**
         * (1) get the length of elements (checkboxes)
         * (2) get the data out of that shitload
         * (3) download
         */
        //length of elements
        const checkboxes = document.querySelector('tbody').querySelectorAll('[type="checkbox"]');
        let arr = [];
        
        for (let i = 0; i < checkboxes.length; i++){
            arr.push({
               name: checkboxes[i].parentNode.lastChild.textContent,
               path: mainPath
        });

        //after everything is ready, get those files
        window.location.href = "/filemanager/api/download/?files=" + JSON.stringify(arr);
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
        
    if(!data.name.toLowerCase().indexOf(enteredText)){
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

    console.log('fetching for..' + searchVal);

    const res = await fetch(`api/data/?mode=search&key=${searchVal}`)    //api/data?direc

    //console.log("fetching... " + directory);
    //globalPathVar = `${directory}`;
    
    const data = await res.json();

    console.log(data);

    return data;
}
/**
 * handel promise from @function globalSearch and fill the table with data
 */
function showSearchResults(){
    globalSearch()
        .then(res => {

            console.log(res.data);
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
function displayTableData(data){
    console.log(data.size);

    let id = document.querySelector('tbody').rows.length;

    return `
        <tr class="dynRow" data-id="${id++}">
            <td class="table-light align-middle"><input type="checkbox" value="1" name="filedata" class=""></input><button class="btn mr-2 ml-2"><i class="${determineFileIcon(data.name, data.type)} fa-2x text-primary"></i></button>${data.name}</td>
            <td class="table-light align-middle">${calcRealSize(data.size)}</td>
            <td class="table-light align-middle">${formatDate(data.date_modified)}</td>
            <td class="table-light text-center align-middle"> 
            <button class="btn btn-outline-danger deleteItem ml-2 float-right"><i class="far fa-trash-alt"></i></button>
            <button class="btn btn-outline-primary downloadItem float-right"><i class="fas fa-cloud-download-alt "></i></button></td>
        </tr>
    `;
}

/**
 * 
 * @param {*} bool - true: show Bottom buttons, false: hide bottomButtons
 */
function showBottomButtons(bool){
    if(bool){
        document.querySelector('#down-remove-btn').classList.remove('invisible');
        document.querySelector('#down-transfer-btn').classList.remove('invisible');
        document.querySelector('#down-download-btn').classList.remove('invisible');
    }else{
        document.querySelector('#down-remove-btn').classList.remove('visible');
        document.querySelector('#down-remove-btn').classList.add('invisible');
        document.querySelector('#down-remove-btn').classList.remove('visible');
        document.querySelector('#down-transfer-btn').classList.add('invisible');
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

/*********************************************************************************
 *                      U T I L I T Y   F U N C T I O N S                        *
 *********************************************************************************/
/**
 *
 * @param {*} arr that contains a name and a path
 */
function createDelteJSONArray(name, path) {
    //get the arr of objects to delete
    let deleteJSON = [];
    deleteJSON.push({
        name: name,
        path: path
    });
    return deleteJSON;
}

/**
 * @param {*} num number to be rounded 
 * @param {*} n numnber of decimals
 * @returns a rounded digit
 */
function roundTo(num, n){
    let f = Math.pow(10, n);
    return Math.round(num * f)/f;
}

/**
 * @param {*} path get the current path
 * @returns a path-array
 */
function setGlobalPath(path){
    tempArr = [];
    paths = path.split('/');
    paths.forEach((el)=>{
       tempArr.push(el);
    });

    return tempArr;
}

/**
 * @param {*} date - the date given by the background 
 * @returns a readable date
 */
function formatDate(date){
    //create new date from unix timestamp
    let newDate = new Date(date*1000);
    
    return newDate.toLocaleString();  // f.e 26.4.2019, 20:04:43  
}

/**
 * @param {*} byte - the size of a file
 * @return its real size 
 */
function calcRealSize(byte){
    if(byte === 0){
        return `0  Byte`;
    }

    if (byte < 1000){
        return `${byte} Byte`
    }
    if (byte < 1000000){
        return `${roundTo(byte/1000, 2)} KB`
    }else if(byte < 1000000000){
        return `${roundTo(byte/1000000, 2)} MB`;
    //guess our application isnt construed for GByte (until now!) 
    }else{
        return `${roundTo(byte/1000, 2)} GB`
    } 
}

/**
 *
 * @param {*} filename get the filename and return the appropriate icon
 * @returns the font-awesome icon-class for the specific @param filename
 */
function determineFileIcon(filename, type){
    let fileending = filename.split('.')[1];
    let iconClass = 'fa fa-info-circle';

    console.log(type);

    if(type === 'folder'){
        return 'fa fa-folder-open';
    }

    switch (fileending) {
        case 'ico':
        case 'gif':
        case 'jpg':
        case 'jpeg':
        case 'jpc':
        case 'jp2':
        case 'jpx':
        case 'xbm':
        case 'wbmp':
        case 'png':
        case 'bmp':
        case 'tif':
        case 'tiff':
        case 'svg':
            iconClass = 'fas fa-file-image';
            break;
        case 'passwd':
        case 'ftpquota':
        case 'sql':
        case 'js':
        case 'json':
        case 'sh':
        case 'config':
        case 'twig':
        case 'tpl':
        case 'md':
        case 'gitignore':
        case 'c':
        case 'cpp':
        case 'cs':
        case 'py':
        case 'map':
        case 'lock':
        case 'dtd':
            iconClass = 'fa fa-file-code';
            break;
        case 'txt':
        case 'ini':
        case 'conf':
        case 'log':
        case 'htaccess':
            iconClass = 'fa fa-file-alt';
            break;
        case 'css':
        case 'less':
        case 'sass':
        case 'scss':
            iconClass = 'fa fa-css3';
            break;
        case 'zip':
        case 'rar':
        case 'gz':
        case 'tar':
        case '7z':
            iconClass= 'fa fa-file-archive';
            break;
        case 'php':
        case 'php4':
        case 'php5':
        case 'phps':
        case 'phtml':
            iconClass= 'fa fa-code';
            break;
        case 'htm':
        case 'html':
        case 'shtml':
        case 'xhtml':
            iconClass = 'fa fa-html5';
            break;
        case 'xml':
        case 'xsl':
            iconClass = 'fa fa-file-excel';
            break;
        case 'wav':
        case 'mp3':
        case 'mp2':
        case 'm4a':
        case 'aac':
        case 'ogg':
        case 'oga':
        case 'wma':
        case 'mka':
        case 'flac':
        case 'ac3':
        case 'tds':
            iconClass= 'fa fa-music';
            break;
        case 'm3u':
        case 'm3u8':
        case 'pls':
        case 'cue':
            iconClass = 'fa fa-headphones';
            break;
        case 'avi':
        case 'mpg':
        case 'mpeg':
        case 'mp4':
        case 'm4v':
        case 'flv':
        case 'f4v':
        case 'ogm':
        case 'ogv':
        case 'mov':
        case 'mkv':
        case '3gp':
        case 'asf':
        case 'wmv':
            iconClass = 'fa fa-file-video';
            break;
        case 'eml':
        case 'msg':
            iconClass = 'fa fa-envelope';
            break;
        case 'xls':
        case 'xlsx':
            iconClass = 'fa fa-file-excel';
            break;
        case 'csv':
            iconClass= 'fa fa-file-text';
            break;
        case 'bak':
            iconClass = 'fa fa-clipboard';
            break;
        case 'doc':
        case 'docx':
            iconClass= 'fa fa-file-word';
            break;
        case 'ppt':
        case 'pptx':
            iconClass= 'fa fa-file-powerpoint';
            break;
        case 'ttf':
        case 'ttc':
        case 'otf':
        case 'woff':
        case 'woff2':
        case 'eot':
        case 'fon':
            iconClass = 'fa fa-font';
            break;
        case 'pdf':
            iconClass = 'fa fa-file-pdf';
            break;
        case 'psd':
        case 'ai':
        case 'eps':
        case 'fla':
        case 'swf':
            iconClass = 'fa fa-file-image';
            break;
        case 'exe':
        case 'msi':
            iconClass = 'fa fa-file';
            break;
        case 'bat':
            iconClass = 'fa fa-terminal';
            break;
        default:
            iconClass = 'fa fa-info-circle';
    }
    return iconClass;


}






