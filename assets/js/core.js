
let currentPath = '';

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
     * @param {*} directoryData - loads the data from a specific directory
     * and displays it in the table
     * forEach if scheme is ready
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
                <td class="pull-right"> <button class="btn btn-danger pull-right"> Löschen </button> </td>
            </tr>
            `;

            document.querySelector('tbody').append(newRow);            
        });
    }

    /**
     * 
     * @param {*} date - the date given by the background formatted 
     */
    function formatDate(date){
        return `${date.getDate()} / ${formatMonth(date.getMonth()+1)} / ${date.getFullYear()} um ${date.getHours()}:${date.getMinutes()}`;
    }

    /**
     * helper method for formatting a month 
     * @param {*} month get the current month and append 0 if under 10
     */
    function formatMonth(month){
        if(month < 10){
            return `0${month}`;
        }else{
            return month;
        }
    }



});


