class Overview {
    writeTreeView(data){

        if (data.length === 0){
            return "";
        };

        let html = "<ul class='list-group mt-3'>",
            that = this;

        data.forEach(function(item){

            if (item.type === "folder"){
                html += '<li class="list-group-item list-group-item-action rounded-0" id="tree-list">';
                    html += '<span class="d-flex justify-content-between align-items-center directory">';
                        html += item.name;
                        if (typeof item.items !== "undefined" && item.items.length > 0){
                            html += '<span class="badge badge-primary badge-pill">' + item.items.length + '</span>';
                        };
                    html += '</span>';
                    if (typeof item.items !== "undefined" && item.items.length > 0){
                        html += that.writeTreeView(item.items);
                    };
                html += '</li>';
            };

        });

        html += '</ul>';

        return html;

    };
};