<?php

	/**
		* Class: IndexController
		* @function: run 
	*/

	class IndexController extends Controller {

		protected $viewFileName = "index";
        protected $loginRequired = true;

		public function run(){
			$this->view->title = "Übersicht";
            $this->view->username = $this->user->username;
		}
	}

?>