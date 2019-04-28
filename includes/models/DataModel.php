<?php

	/**
		* Class: DataModel
		* @function: getDataFromDirectory, createDirectory, deleteData
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

                    $path = $directory . "/" . $file;

                    if (!is_dir($path)){

                        // File

                        $files[] = array(
                            "date_modified" => filemtime($path),
                            "extension" => pathinfo($file, PATHINFO_EXTENSION),
                            "name" => $file,
                            "path" => $path,
                            "type" => "file",
                            "size" => filesize($path)
                        );

                    } else {

                        // Directory

                        $files[] = array(
                            "date_modified" => filemtime($path),
                            "items" => (array) self::getDataFromDirectory($path),
                            "name" => $file,
                            "path" => $path,
                            "type" => "folder",
                            "size" => filesize($path)
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
		public static function createDirectory($path){

            $msg = "";

            if (!file_exists($path)){
                if (mkdir($path, 0777, true)){
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

        /**
            * Get data for search
            * @param: $directory(string), $key(string)
            * @return: $files(object)
        */
        public static function getDataForSearch($directory, $key){

            $files = array();

            // Check if directory exists

            if (file_exists($directory)){

                // Scan directories

                $response = scandir($directory);

                foreach ($response as $file){

                    // Ignore hidden files and directories

                    if (!$file || $file[0] == "."){
                        continue;
                    };

                    if (is_dir($directory . "/" . $file)){

                        // Directory

                        $path = $directory . "/" . $file;

                        return (array) self::getDataForSearch($path, $key);

                    } else {

                        // File

                        if (preg_match("/" . $key . "/i", $file)){

                            $files[] = array(
                                "date_modified" => filemtime($directory . "/" . $file),
                                "extension" => pathinfo($file, PATHINFO_EXTENSION),
                                "name" => $file,
                                "path" => $directory,
                                "type" => "file",
                                "size" => filesize($directory . "/" . $file)
                            );

                        };

                    };

                };

            };

            return (object) $files;

        }
		
	}

?>