<?php

	define("API_CALL", true);
	require_once(__DIR__ . "/includes/initialize.php");

	$user = new User();
	$user->authenticate();

	class ApiController{

		public function run(){

			global $restfulservices;

			$request_method = strtolower($_SERVER["REQUEST_METHOD"]);
			$requesturi = $_SERVER["REQUEST_URI"];

			$parts = explode("/api/", $requesturi);

			$rightpart = $parts[1];

			if ($rightpart == ""){
				$jsonResponse = new JSON();
				$jsonResponse->result = false;
				$jsonResponse->setMessage("No Service specified! You need to specify a service when you call the API!");
				$jsonResponse->send();
			} else {

				$serviceParts = explode("/", $rightpart);
				$serviceName = $serviceParts[0];
				unset($serviceParts[0]);

				switch ($request_method){
					case "get":
						$data = $_GET;
						if (empty($data)) $data = array();
						break;
					case "post":
						$data = $_POST;
						break;
					case "put":
						parse_str(file_get_contents("php://input"), $put_vars);
						$data = $put_vars;
						$data = ($data) ? $data : $_GET;
						break;
					case "delete":
						parse_str(file_get_contents("php://input"), $put_vars);
						$data = $put_vars;
						$data = ($data) ? $data : $_GET;
						break;
				};

				$dataForApi = $data;

				if (!empty($restfulservices)){
					foreach ($restfulservices as $callback){
						if (strtolower($callback[0]) == $serviceName){
							$restServiceToCall = new $serviceName();
							$restServiceToCall->{$callback[1]}($request_method, $dataForApi);
						};
					};
				} else {
					$jsonResponse = new \JSON();
					$jsonResponse->result = false;
					$jsonResponse->setMessage("No Services defined! Ensure that there are services registered!");
					$jsonResponse->send();
				};

				$jsonResponse = new \JSON();
				$jsonResponse->result = false;
				$jsonResponse->setMessage("Default Response - no Service Registered found that fits the api call!");
				$jsonResponse->send();

			};

		}

	};

	$api = new ApiController();
	$api->run();

?>