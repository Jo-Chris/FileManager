<?php

    /**
        * Class: Data
<<<<<<< HEAD
        * @function: getRequest, createRequest, saveRequest, deleteRequest
=======
        * @function: __construct, __destruct, getRequest, createRequest, saveRequest, deleteRequest
>>>>>>> feature-rest
    */

    class Data extends RESTClass {

<<<<<<< HEAD
        protected function getRequest($data){}
=======
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
>>>>>>> feature-rest

        protected function createRequest($data){}

        protected function saveRequest($data){}

        protected function deleteRequest($data){}

    }

?>