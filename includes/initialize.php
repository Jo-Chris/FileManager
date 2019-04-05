<?php

	// --- Initialize --- //

	// Show all errors, excluding NOTICE errors
	error_reporting(E_ALL & ~E_NOTICE);

	// Define view directory
	define("VIEW_DIRECTORY", __DIR__ . "/views/");

	// Start session
	session_start();

	// Include files
	require_once(__DIR__ . "/dbconfig.php");
	require_once(__DIR__ . "/routes.php");
	require_once(__DIR__ . "/restservices.php");
	require_once(__DIR__ . "/config.php");

	// Load class, error if file not exists

	if (!function_exists("classAutoLoader")){

		function classAutoLoader($fileName){
			if (file_exists(__DIR__ . "/classes/" . $fileName . ".php")){
				require_once(__DIR__ . "/classes/" . $fileName . ".php");
			} else if (file_exists(__DIR__ . "/models/" . $fileName . ".php")){
				require_once(__DIR__ . "/models/" . $fileName . ".php");
			} else if (file_exists(__DIR__ . "/controllers/" . $fileName . ".php")){
				require_once(__DIR__ . "/controllers/" . $fileName . ".php");
			} else if (file_exists(__DIR__ . "/restservices/" . $fileName . ".php")){
				require_once(__DIR__ . "/restservices/". $fileName. ".php");
			} else {
				throw new Exception("Unable to load $fileName.");
			};
		};

	};

	// Load class async
	spl_autoload_register("classAutoLoader");

?>