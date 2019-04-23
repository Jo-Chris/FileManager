<?php

	/**
		* Class: DataModel
		* @function: getDataFromDirectory
	*/

	class DataModel {

		public static function getDataFromDirectory($directory){

            $files = array();

            // Check if directory exists

            if (file_exists($directory)){

                // Scan directory

                $response = scandir($directory);

                foreach ($response as $file){

                    // Ignore hidden files and directories

                    if (!$file || $file[0] == "."){
                        continue;
                    };

                    if (!is_dir($directory . "/" . $file)){

                        // File

                        $files[] = array(
                            "extension" => pathinfo($file, PATHINFO_EXTENSION),
                            "name" => $file,
                            "path" => $directory . "/" . $file,
                            "type" => "file",
                            "size" => filesize($directory . "/" . $file)
                        );

                    } else {

                        // Directory

                        $files[] = array(
                            "items" => (array) self::getDataFromDirectory($directory . "/" . $file),
                            "name" => $file,
                            "path" => $directory . "/" . $file,
                            "type" => "folder",
                            "size" => filesize($directory . "/" . $file)
                        );

                    };

                };

            };

            return (object) $files;

        }
		
	}

?>