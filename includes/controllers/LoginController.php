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

	}
?>