<?php

	/**
		* Class: DataModel
		* @function: getDataFromDirectory
	*/

	class DataModel {

		public static function getDataFromDirectory($directory){

			$directory = "cloud";
			$files = array();

			if (file_exists($directory)){

			    echo "2";
			    return;

				$response = scandir($directory);

				foreach ($response as $file){
					if (is_dir($directory . "/" . $file)){
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