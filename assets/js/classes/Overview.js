class Overview {
    constructor(){



    };
    writeTreeView(data){

        let html = "<ul class='list-group'>";

        $(data).each(function(index){

            let item = data[index];

            if (item.type === "folder"){
                html += '<li class="list-group-item list-group-item-action">';
                    html += '<span>' + item.name + '</span>';
                html += '</li>';
            };

        });

        html += '</ul>';

        return html;

    };
};