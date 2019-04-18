<?php

    /**
        * Class: Data
        * @function: __construct, __destruct, getRequest, createRequest, saveRequest, deleteRequest
    */

    class Data extends RESTClass {

        public function __construct(){}

        public function __destruct(){}

        protected function getRequest($data){

            $data["directory"] = "cloud";

            if (isset($data["directory"])){

                $dataForView = DataModel::getDataFromDirectory($data["directory"]);

                return;

                $jsonResponse = new JSON();
                $jsonResponse->result = true;
                $jsonResponse->setData($dataForView);
                $jsonResponse->send();

            };

        }

        protected function createRequest($data){}

        protected function saveRequest($data){}

        protected function deleteRequest($data){}

    }

?>