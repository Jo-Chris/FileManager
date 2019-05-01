<?php

    /**
        * Class: Account
        * @function: getRequest
    */

    class Account extends RESTClass {

        /**
            * GET Request
            * @param: $data(array)
        */
        protected function getRequest($data){

            // Check if params set

            if (isset($data["email"]) && isset($data["activationKey"])){
                // Activate user for login
                AccountModel::activateUser($data["email"], $data["activationKey"]);
            };

        }

        protected function createRequest($data){}

        protected function saveRequest($data){}

        protected function deleteRequest($data){}

    }

?>