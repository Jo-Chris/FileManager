<?php

    /**
        * Class: AccountModel
        * @function: activateUser
    */

    class AccountModel {

        /**
            * Activate user
            * @param: $email(string), $activationKey(string)
        */
        public static function activateUser($email, $activationKey){

            $db = new Database();
            $sql = "UPDATE user SET active = 1 WHERE email = '{$email}' AND activationKey = '{$activationKey}'";
            $result = $db->query($sql);

            header("HTTP/1.0 200 OK", true, 200);
            header("Location: " . URL_PATH . "/login");
            exit;

        }

    }

?>