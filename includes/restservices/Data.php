<?php

    /**
        * Class: Data
        * @function: getRequest, createRequest, saveRequest, deleteRequest
    */

    class Data extends RESTClass {

        /**
            * GET Request
            * @param: $data(array)
        */
        protected function getRequest($data){

            // Check if params set

            if (!isset($data["directory"])){
                $data["directory"] = ROOT_URL;           
            };

            if (isset($data["mode"]) && isset($data["key"]) && $data["mode"] === "search"){
                // Get data for search
                $dataForView = DataModel::getDataForSearch($data["directory"], $data["key"]);
            } else {
                // Get data from specific directory
                $dataForView = DataModel::getDataFromDirectory($data["directory"]);
            };

            // Return json
            $jsonResponse = new JSON();
            $jsonResponse->result = true;
            $jsonResponse->setData($dataForView);
            $jsonResponse->send();

        }

        /**
            * CREATE Request
            * @param: $data(array)
        */
        protected function createRequest($data){

            // Check if params set

            if (isset($data["name"]) && isset($data["path"])){

                // Create directory
                $path = $data["path"] . "/" . $data["name"];
                $dataForView = DataModel::createDirectory($path);

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

        /**
            * DELETE Request
            * @param: $data(array)
        */
        protected function deleteRequest($data){

            // Check if params set

            if (isset($data["files"])){

                // Delete file or directory
                $dataForView = DataModel::deleteData($data["files"]);

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
            }

        }

    }

?>