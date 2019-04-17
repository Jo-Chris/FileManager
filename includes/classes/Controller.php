<?php

	/**
		* Abstract Class: Controller
		* @function: run, __construct, output
	*/

	abstract class Controller {
		
		protected $viewFileName = "";
		public $pageName = "";
		protected $view = null;
		protected $user = null;

		abstract function run();

		public function __construct($pageName){

			$this->pageName = $pageName;

			$this->user = new User();

			// Show view of current page by filename
			$this->view = new View($this->viewFileName, $pageName);

			$this->run();
			$this->output();

		}

		private function output(){
			$this->view->output();
		}

	}

?>