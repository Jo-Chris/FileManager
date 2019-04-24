<?php

	/**
		* Class: DataModel
		* @function: getDataFromDirectory
    */
    
    
	class DataModel {

        /**
			* Get data from directory
            * @param: $directory(string)
            * @return: $files(object)
		*/
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

        /**
			* Create new directory
            * @param: $name(string), $path(string)
            * @return: $msg(string)
		*/
		public static function createDirectory($name, $path){

            $msg = "";

            if (!file_exists($path . "/" . $name)){
                if (mkdir($path . "/" . $name, 0777, true)){
                    $msg = "Folder successfully created";
                } else {
                    $msg = "Folder couldn't be created";
                };
            } else {
                $msg = "Folder already exists";
            }; 

            return $msg;

        }

        /**
			* Delete file or directory
            * @param: $path(string)
            * @return: $msg(object)
		*/
		public static function deleteData($path){

            $msg = "";

            if (is_link($path)){

                unlink($path);
                $msg = "File successfully deleted";

            } elseif (is_dir($path)){

                $objects = scandir($path);
                $ok = true;

                if (is_array($objects)){
                    foreach ($objects as $file){
                        if ($file !== "." && $file !== ".."){
                            if (!self::deleteData($path . "/" . $file)){
                                $ok = false;
                            };
                        };
                    };
                };

                if ($ok){
                    rmdir($path);
                    $msg = "Folder successfully deleted";
                };

            } elseif (is_file($path)){
                unlink($path);
                $msg = "File successfully deleted";
            } else {
                $msg = "Folder or file couldn't be deleted";
            };

            return $msg;

        }
		
	}

?>