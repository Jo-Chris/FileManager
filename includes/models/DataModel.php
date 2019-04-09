<?php

	/**
		* Class: DataModel
		* @function: run
	*/

	class DataModel {

		public static function getDataFromDirectory($directory){

			$directory = "cloud";
			$files = array();

			if (file_exists($directory)){
				$response = scandir($directory);
				foreach ($response as $file){
					if (is_dir($dir . "/" . $file)){		
						$files[] = array(
							"name" => $file,
							"type" => "folder",
							"path" => $directory . "/" . $file
						);
					} else {
						$files[] = array(
							"name" => $file,
							"type" => "file",
							"path" => $directory . "/" . $file
						);
					};
				};
			};

			return (object) $files;

		}
		
	}

?>