<?php

    /**
        * Class: Data
        * @function: getRequest, createRequest, saveRequest, deleteRequest
    */

    class Data extends RESTClass {

        protected function getRequest($data){

            if (!isset($data["directory"])){
                $data["directory"] = ROOT_URL;           
            };

            if (isset($data["mode"]) && isset($data["key"]) && $data["mode"] === "search"){
                $dataForView = DataModel::getDataForSearch($data["directory"], $data["key"]);
            } else {
                $dataForView = DataModel::getDataFromDirectory($data["directory"]);
            };

            $jsonResponse = new JSON();
            $jsonResponse->result = true;
            $jsonResponse->setData($dataForView);
            $jsonResponse->send();

        }

        protected function createRequest($data){

            if (isset($data["name"]) && isset($data["path"])){

                $path = $data["path"] . "/" . $data["name"];
                $dataForView = DataModel::createDirectory($path);

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

        protected function deleteRequest($data){

            if (isset($data["files"])){

                $dataForView = DataModel::deleteData($data["files"]);

                $jsonResponse = new JSON();
                $jsonResponse->result = true;
                $jsonResponse->setMessage($dataForView);
                $jsonResponse->send();

            } else {
                $jsonResponse = new JSON();
                $jsonResponse->result = false;
                $jsonResponse->send();
            }

        }

    }

?>