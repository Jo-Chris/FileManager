<?php

    /**
        * Class: Upload
        * @function: getRequest, createRequest, saveRequest, deleteRequest
    */

    class Upload extends RESTClass {

        protected function getRequest($data){}

        /**
            * CREATE Request
            * @param: $data(array)
        */
        protected function createRequest($data){

            // Check if params set

            if (isset($data["path"]) && isset($_FILES["files"])){

                // Upload file
                $dataForView = UploadModel::uploadFile($data["path"], $_FILES["files"]);

                // Return json
                $jsonResponse = new JSON();
                $jsonResponse->result = true;
                $jsonResponse->setMessage($dataForView);
                $jsonResponse->send();

            } else {

                // Return json
                $jsonResponse = new JSON();
                $jsonResponse->result = false;
                $jsonResponse->send();

            };

        }

        protected function saveRequest($data){}

        protected function deleteRequest($data){}

    }

?>