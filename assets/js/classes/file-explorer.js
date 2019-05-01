$(function(){

    $.fn.filetree = function(method){

        var settings = {
            animationSpeed      : "fast",
            collapsed           : true,
            console             : false
        };

        var methods = {
            init : function(options){

                var options = $.extend(settings, options);

                return this.each(function(){

                    var $fileList = $(this);

                    $fileList
                        .addClass("file-list")
                        .find("li")
                        .addClass("folder-root closed")
                        .on("click", "a[href='#']", function(e){

                            e.preventDefault();

                            if ($(this).parent().children("ul").length > 0){
                                $(this).parent().toggleClass("closed").toggleClass("open");
                            };

                            $fileList.find("li").removeClass("selected");
                            $(this).parent().addClass("selected");

                            const data = loadDirectory($(this).attr("data-path"))
                                .then(res => showDirectoryData(res.data));

                            return false;

                        });

                });

            }
        };


        if (typeof method === "object" || !method){
            return methods.init.apply(this, arguments);
        } else {
            $.on( "error", function(){
                console.log(method + " does not exist in the file exploerer plugin");
            });
        };

    };

});