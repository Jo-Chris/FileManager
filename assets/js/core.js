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
    document.getElementById('main-list').addEventListener('click', setActiveEl);

    function clickFn(e){
        if(e.target.classList.contains('directory')){
            //fetch api with current folder
            const data = loadDirectory(e.target.getAttribute("data-path"))
            .then(res => showDirectoryData(res.data[0]));
        }
    }

    function setActiveEl(e){
        //get the clicked element, add class .active for blue background
        //remove from every other element 
    }

    //this directory needs to get the path of the folder
    async function loadDirectory(directory){
        const res = await fetch(`api/data/?directory=${directory}`)    //api/data?direc

        console.log("Will do a fetch for directory: " + directory);
       
        const data = await res.json();

        return data;
    }

    function showDirectoryData(directoryData){
        const mainTable = document.querySelector('#tbody-table');
        console.log(mainTable);

        const newRow = document.createElement('tr');

        newRow.innerHTML = 
        `<tr>
            <td>....</td>
            <td>${directoryData.name}</td>
            <td>${directoryData.size}</td>
            <td>....</td>
        </tr>
        `;

        mainTable.append(newRow);
    }

    function showActiveElement(e){
        e.classList += "active";
    }
});