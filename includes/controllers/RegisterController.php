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
                $errorFields = array();

                foreach ($requiredFields as $fieldName){
                    if(!isset($_POST[$fieldName]) || $_POST[$fieldName] == ""){
                        $error = true;
                        $errorFields[$fieldName] = "Bitte Wert eingeben!";
                    };
                };

                if (!$error){

                    $password = $_POST["password"];
                    $email = $_POST["email"];

                    if (strlen($password) < 8){
                        $error = true;
                        $errorFields["password"] = "Passwort ist zu kurz! Bitte mindestens 8 Zeichen eingeben";
                    } else if ($password != $_POST["passwordconfirmation"]){
                        $error = true;
                        $errorFields["passwordconfirmation"] = "Passwort Wiederholung entspricht nicht dem gleichen Wert von Passwort!";
                    };

                    if (!$error){

                        if (User::existsWithEMail($email) == false){

                            User::createUser(array("gender" => $_POST["gender"], "firstname" => $_POST["firstname"], "lastname" => $_POST["lastname"], "email" => $email, "email" => $email, "password" => $password));

                            $jsonResponse = new JSON();
                            $jsonResponse->result = true;
                            $jsonResponse->setMessage("Benutzer wurde erfolgreich hinzugefügt!");
                            $jsonResponse->send();

                        } else {

                            $errorFields["name"] = "Benutzername ist schon vorhanden!";

                            $jsonResponse = new JSON();
                            $jsonResponse->result = false;
                            $jsonResponse->setData(array("errorFields" => $errorFields));
                            $jsonResponse->send();

                        };

                    };

                };

                $jsonResponse = new JSON();
                $jsonResponse->result = false;
                $jsonResponse->setData(array("errorFields" => $errorFields));
                $jsonResponse->send();

            };

        }

    }

?>