<?php

	/**
		* Class: IndexController
		* @function: run 
	*/

	class IndexController extends Controller {

		protected $viewFileName = "index";

		public function run(){
			$this->view->title = "Übersicht";

		}
	}

?>