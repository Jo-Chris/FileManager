<?php

	/**
		* Class: LoginController
		* @function: run 
	*/

	class LoginController extends Controller {

		protected $viewFileName = "login";

		public function run(){
			$this->view->title = "Login";
		}

		public function login(){
		    if(!empty($_POST) && isset($_POST['action']) && $_POST['action'] == 'login'){
                $email = $_POST['email'];
                $password = $_POST['password'];


                if($this->user->login($email, $password)){
                    $this->user->redirectToIndex();
                }else{
                    //show err
                }

            }
        }

	}
?>