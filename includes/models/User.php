<?php

    class User extends Database {

        private $user_firstname;
        private $user_lastname;
        private $user_email;
        private $user_password;
        private $user_active;
        private $user_activationKey;

        private $isLoggedIn = false;

        public function __construct() {

        }


        public static function createUser($userdata){
            $db = new Database();

            $user_firstname = $db->escapeString($userdata['firstname']);
            $user_lastname = $db->escapeString($userdata['lastname']);
            $user_email = $db->escapeString($userdata['email']);
            $user_password = $db->escapeString($userdata['password']);

            $sql = "INSERT INTO `user`(`firstname`, `lastname`, `email`, `password`) VALUES ($user_firstname, $user_lastname, $user_email, $user_password)";
            $db->query($sql);
        }

        public function login($email, $password){
            $sql = "SELECT `email`,`password` FROM `user` WHERE `name`='" . $this->escapeString($email) . "'";
            $result = $this->query($sql);


            if($this->numRows($result) == 0){
                $this->isLoggedIn = false;
                return false; //username not found!
            }

            $row = $this->fetchObject($result);

            if(password_verify($password, $row->password)){
                $this->user_email = $email;
                $this->id = $row->id;
                $this->isLoggedIn = true;

                return true;
            }

            $this->isLoggedIn = false;
            return false;

        }

        public function redirectToIndex()
        {
            header('Location: '.INDEX_URL);
            header('Status: 303');
            exit();
        }

        public function getUserLastname(){
            return $this->user_lastname;
        }

        public function getUserFirstname(){
            return $this->user_firstname;
        }

        public function getUserEmail() {
            return $this->user_email;
        }

        public function getUserPassword() {
            return $this->user_password;
        }

        public function getUserActivationKey() {
            return $this->user_activationKey;
        }

        public function setUserLastname($user_lastname) {
            $this->user_lastname = $user_lastname;
        }

        public function setUserEmail($user_email){
            $this->user_email = $user_email;
        }

        public function setUserPassword($user_password)
        {
            $this->user_password = $user_password;
        }

        public function getUserActive() {
            return $this->user_active;
        }

        public function setUserActive($user_active) {
            $this->user_active = $user_active;
        }

        public function setUserFirstname($user_firstname) {
            $this->user_firstname = $user_firstname;
        }

        public function setUserActivationKey($user_activationKey) {
            $this->user_activationKey = $user_activationKey;
        }

    }

?>