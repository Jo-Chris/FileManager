<?php

    /**
        * Class: Download
        * @function: getRequest, createRequest, saveRequest, deleteRequest
    */

    class Download extends RESTClass {

        protected function getRequest($data){
            if (isset($data["files"])){
                $dataForView = DownloadModel::downloadFile($data["files"]);
            };
        }

        protected function createRequest($data){}

        protected function saveRequest($data){}

        protected function deleteRequest($data){}

    }

?>