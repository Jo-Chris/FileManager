<?php

	/**
		* Class: LoginController
		* @function: run, checkForLoginPost
	*/

	class LoginController extends Controller {

		protected $viewFileName = "login";
        protected $loginRequired = false;

		public function run(){

			$this->view->title = "Login";

            if ($this->user->isLoggedIn){
                $this->user->redirectToIndex();
            };

            $this->checkForLoginPost();

		}

        private function checkForLoginPost(){

            if (!empty($_POST) && isset($_POST["action"]) && $_POST["action"] == "login"){

                $email = $_POST["email"];
                $password = $_POST["password"];

                if ($email != "" && $password != ""){
                    if ($this->user->login($email, $password)){
                        $this->user->redirectToIndex();
                    } else {
                        $this->view->errorPasswd = true;
                    };
                };

            };

        }

	}

?>