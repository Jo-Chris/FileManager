<?php

    /**
        * Class: Download
        * @function: getRequest, createRequest, saveRequest, deleteRequest
    */

    class Download extends RESTClass {

        /**
            * GET Request
            * @param: $data(array)
        */
        protected function getRequest($data){

            // Check if params set

            if (isset($data["files"])){
                // Download file
                DownloadModel::downloadFile($data["files"]);
            };

        }

        protected function createRequest($data){}

        protected function saveRequest($data){}

        protected function deleteRequest($data){}

    }

?>