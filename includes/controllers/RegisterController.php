<?php

    /**
        * Class: RegisterController
        * @function: run, checkForRegisterPost
    */

    class RegisterController extends Controller {

        protected $viewFileName = "register";
        protected $loginRequired = false;

        public function run(){

            $this->view->title = "Register";

            if ($this->user->isLoggedIn){
                $this->user->redirectToIndex();
            };

            $this->checkForRegisterPost();

        }

        private function checkForRegisterPost(){

            if (!empty($_POST) && isset($_POST["action"]) && $_POST["action"] == "register"){

                $requiredFields = array("gender", "firstname", "lastname", "email", "password", "passwordconfirmation");

                $error = false;
                $this->view->errorMsg = "";

                foreach ($requiredFields as $fieldName){
                    if(!isset($_POST[$fieldName]) || $_POST[$fieldName] == ""){
                        $error = true;
                        $this->view->errorMsg = "Bitte alle Pflichtfelder eingeben!";
                    };
                };

                if (!$error){

                    $password = $_POST["password"];
                    $email = $_POST["email"];

                    if (strlen($password) < 8){
                        $error = true;
                        $this->view->errorMsg = "Passwort ist zu kurz! Bitte mindestens 8 Zeichen eingeben";
                    } else if ($password != $_POST["passwordconfirmation"]){
                        $error = true;
                        $this->view->errorMsg = "Passwort Wiederholung entspricht nicht dem gleichen Wert von Passwort!";
                    };

                    if (!$error){

                        if (User::existsWithEMail($email) == false){

                            User::createUser(array("gender" => $_POST["gender"], "firstname" => $_POST["firstname"], "lastname" => $_POST["lastname"], "email" => $email, "email" => $email, "password" => $password));

                            header("HTTP/1.0 200 OK", true, 200);
                            header("Location: " . URL_PATH . "/login");
                            exit;

                        } else {
                            $this->view->errorMsg = "Benutzername ist schon vorhanden!";
                        };

                    };

                } else {
                    $this->view->errorMsg = "Benutzername konnte nicht registriert werden!";
                };

            };

        }

    }

?>