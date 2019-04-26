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
    document.getElementById('select-all').addEventListener('click', selectAll);
    document.getElementById('de-select-all').addEventListener('click', deSelectAll);
    document.getElementById('reverse-selection').addEventListener('click', reverseSelection);

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
        globalPathVar = `${directory}`;
        
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
                    <td class="table-light align-middle"><input type="checkbox" value="1" name="filedata" class="form-control checkbox" ></input></td>
                    <td class="table-light"><button class="btn mr-2"><i class="${determineFileIcon(data.name)} fa-2x"></i></button>${data.name}</td>
                    <td class="table-light">${data.size}</td>
                    <td class="table-light">${formatDate(new Date())}</td>
                    <td class="table-light" align-right"> <button class="btn btn-danger float-right deleteItem"><i class="far fa-trash-alt"></i> Löschen </button> </td>
                </tr>
                `;

            //append the row
            document.querySelector('tbody').append(newRow);       
            //if fetch was successful, show the action-buttons
            showBottomActions();
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
     * This function is based on a indexOf comparison and filters through the array
     * @todo saving the tableData into an global array is... well, shit
     */
    function searchForFiles(){
        //if the user removes all entered chars, get the old stuff back in
         if (document.querySelector('#searchbar').value == ''){
            showDirectoryData(globalArrayVal);
         }
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
                    <td class="table-light"><button class="btn mr-2"><i class="${determineFileIcon(data.name)}"></i></button>${data.name}</td>
                    <td class="table-light">${data.size}</td>
                    <td class="table-light">${formatDate(new Date())}</td>
                    <td class="table-light" align-right"> <button class="btn btn-danger float-right deleteItem"><i class="fa fa-file-word"></i> Löschen </button> </td>
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
    
    

    /****************************
     * Bottom Action Area       *
     ****************************/

    function showBottomActions(){
        document.getElementById('button-action-container').style.display = 'block';
    }

    function selectAll(){
        const checkboxes = document.querySelector('tbody').querySelectorAll('[type="checkbox"]');
        checkboxes.forEach((el) => {
            el.checked = true;
        })
    }

    function deSelectAll(){
        const checkboxes = document.querySelector('tbody').querySelectorAll('[type="checkbox"]');
        checkboxes.forEach((el) => {
            el.checked = false;
        });
    }

    function reverseSelection(){
        const checkboxes = document.querySelector('tbody').querySelectorAll('[type="checkbox"]');
        checkboxes.forEach((el) => {
            el.checked ? el.checked = false : el.checked = true;
        })
    }
    
    /**
     * 
     * @param {*} filename get the filename and return the appropriate icon
     */
    function determineFileIcon(filename){
        let fileending = filename.split('.')[1];
        let iconClass = 'fa fa-info-circle';
        
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
        console.log(iconClass);
        return iconClass;
    }
});


