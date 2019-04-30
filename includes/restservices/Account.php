<?php

    /**
        * Class: Account
        * @function: getRequest
    */

    class Account extends RESTClass {

        protected function getRequest($data){
            if (isset($data["email"]) && isset($data["activationKey"])){
                AccountModel::activateUser($data["email"], $data["activationKey"]);
            };
        }

        protected function createRequest($data){}

        protected function saveRequest($data){}

        protected function deleteRequest($data){}

    }

?>