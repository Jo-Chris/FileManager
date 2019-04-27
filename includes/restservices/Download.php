<?php

    /**
        * Class: Download
        * @function: getRequest, createRequest, saveRequest, deleteRequest
    */

    class Download extends RESTClass {

        protected function getRequest($data){
            if (isset($data["path"]) && isset($data["name"])){
                $dataForView = DownloadModel::downloadFile($data["path"], $data["name"]);
            };
        }

        protected function createRequest($data){}

        protected function saveRequest($data){}

        protected function deleteRequest($data){}

    }

?>