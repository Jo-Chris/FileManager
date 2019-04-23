<?php

    /**
        * Class: Data
        * @function: __construct, __destruct, getRequest, createRequest, saveRequest, deleteRequest
    */

    class Data extends RESTClass {

        public function __construct(){}

        public function __destruct(){}

        protected function getRequest($data){

            if (!isset($data["directory"])){
                $data["directory"] = ROOT_URL;           
            };

            echo $data["directory"];
            return;

            $dataForView = DataModel::getDataFromDirectory($data["directory"]);

            $jsonResponse = new JSON();
            $jsonResponse->result = true;
            $jsonResponse->setData($dataForView);
            $jsonResponse->send();

        }

        protected function createRequest($data){

            if (isset($data["name"]) && isset($data["path"])){

                if ($data["type"] === "folder"){
                    $dataForView = DataModel::createDirectory($data["name"], $data["path"]);
                } else {
                    $dataForView = DataModel::createFile($data["name"], $data["path"]);
                };

                $jsonResponse = new JSON();
                $jsonResponse->result = true;
                $jsonResponse->setData($dataForView);
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