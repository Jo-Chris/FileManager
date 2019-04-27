<?php

    /**
        * Class: Upload
        * @function: getRequest, createRequest, saveRequest, deleteRequest
    */

    class Upload extends RESTClass {

        protected function getRequest($data){}

        protected function createRequest($data){

            if (isset($data["path"]) && isset($_FILES["files"])){

                $dataForView = UploadModel::uploadFile($data["path"], $_FILES["files"]);

                $jsonResponse = new JSON();
                $jsonResponse->result = true;
                $jsonResponse->setMessage($dataForView);
                $jsonResponse->send();

            } else {
                $jsonResponse = new JSON();
                $jsonResponse->result = false;
                $jsonResponse->send();
            };

        }

        protected function saveRequest($data){}

        protected function deleteRequest($data){}

    }

?>