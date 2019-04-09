<?php

    class User {

        private $user_firstname;
        private $user_lastname;
        private $user_email;
        private $user_password;
        private $user_active;
        private $user_activationKey;

        public function __construct($user_firstname, $user_lastname, $user_email, $user_password){
            $this->$user_firstname = $user_firstname;
            $this->$user_lastname = $user_lastname;
            $this->$user_email = $user_email;
            $this->$user_password = $user_password; //encrypt
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