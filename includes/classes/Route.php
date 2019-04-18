<?php

	/**
		* Class: Route
		* @function: __construct, runControllerByUrl
	*/

	class Route {

		public function __construct(){
			$this->runControllerByUrl();
		}

		/**
			* Run controller by URL
		*/
		public function runControllerByUrl(){

			global $route;

			// Get request url
			$requestUri = $_SERVER["REQUEST_URI"];

			// Get url segments
			$parts = explode("?", $requestUri);

			$requestUri = $parts[0];

			$urlPath = URL_PATH;

			if ($urlPath == "/"){
				$urlPath = "";
			};

			// Define controller
			foreach ($route as $key => $routeOption){
				if ($requestUri == $urlPath.$key){
					$controller = new $routeOption["controller"]($routeOption["uniqueName"]);
					exit;
				};
			};

            define("LOGGED_IN", false);
			// Show 404 error page
			$view = new View("404");
			http_response_code(404);
			$view->output();

		}

	}

?>