
/*********************************************************************************
 *                      U T I L I T Y   F U N C T I O N S                        *
 *********************************************************************************/

 class Utils {

    /**
     * @param {*} arr that contains a name and a path
     */
    createDeleteJSONArray(name, path) {
        //get the arr of objects to delete
        let deleteJSON = [];
        deleteJSON.push({
            name: name,
            path: path
        });
        return deleteJSON;
    }

    /**
     * @param {*} path get the current path
     * @returns a path-array
     */
    setGlobalPath(path){
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
    formatDate(date){
        //create new date from unix timestamp
        let newDate = new Date(date*1000);
        
        return newDate.toLocaleString();  // f.e 26.4.2019, 20:04:43  
    }

    /**
     * @param {*} byte - the size of a file
     * @return its real size 
     */
    calcRealSize(byte){
        if(byte === 0){
            return `0  Byte`;
        }

        if (byte < 1000){
            return `${byte} Byte`
        }
        if (byte < 1000000){
            return `${this.roundTo(byte/1000, 2)} KB`
        }else if(byte < 1000000000){
            return `${this.roundTo(byte/1000000, 2)} MB`;
        //guess our application isnt construed for GByte (until now!) 
        }else{
            return `${this.roundTo(byte/1000, 2)} GB`
        } 
    }

    /**
     * @param {*} num number to be rounded 
     * @param {*} n numnber of decimals
     * @returns a rounded digit
     */
    roundTo(num, n){
        let f = Math.pow(10, n);
        
        return Math.round(num * f)/f;
    }

    /**
     *
     * @param {*} filename get the filename and return the appropriate icon
     * @returns the font-awesome icon-class for the specific @param filename
     */
    determineFileIcon(filename, type){
        let fileending = filename.split('.')[1];
        let iconClass = 'fa fa-info-circle';

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
}
    