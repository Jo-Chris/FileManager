<?php

	/**
		* Class: DataModel
		* @function: getDataFromDirectory, createDirectory, deleteData
    */
    
	class DataModel {

	    public static $searchFiles = array();

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
                            "date_modified" => filemtime($directory . "/" . $file),
                            "extension" => pathinfo($file, PATHINFO_EXTENSION),
                            "name" => $file,
                            "path" => $directory,
                            "type" => "file",
                            "size" => filesize($directory . "/" . $file)
                        );

                    } else {

                        // Directory

                        $files[] = array(
                            "date_modified" => filemtime($directory . "/" . $file),
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
		public static function createDirectory($path){

            $msg = "";

            // Check if directory exists, otherweise create directory

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
            * @param: $files(array)
            * @return: $msg(object)
		*/
		public static function deleteData($files){

            $msg = array();

            // Iterate through files

            $filesArray = json_decode($files, true);

            for ($i = 0; $i < count($filesArray); $i++){

                $path = $filesArray[$i]["path"] . "/" . $filesArray[$i]["name"];

                if (is_link($path)){

                    // File successfully deleted

                    unlink($path);

                    // Save download in db

                    $db = new Database();
                    $sql = "DELETE FROM file WHERE filename = '" . $filesArray[$i]["name"] . "' AND path = '" . $filesArray[$i]["path"] . "'";
                    $db->query($sql);

                    $msg[] = array(
                        "name" => $filesArray[$i]["name"],
                        "path" => $filesArray[$i]["path"],
                        "message" => "File successfully deleted"
                    );

                } elseif (is_dir($path)){

                    // If directory scan them and delete file

                    $objects = scandir($path);
                    $ok = true;

                    if (is_array($objects)){
                        foreach ($objects as $file) {
                            if ($file !== "." && $file !== "..") {
                                if (!self::deleteData($path . "/" . $file)) {
                                    $ok = false;
                                };
                            };
                        };
                    };

                    if ($ok){

                        // Folder successfully deleted

                        rmdir($path);

                        $msg[] = array(
                            "name" => $filesArray[$i]["name"],
                            "path" => $filesArray[$i]["path"],
                            "message" => "Folder successfully deleted"
                        );

                    };

                } elseif (is_file($path)){

                    // File successfully deleted

                    unlink($path);

                    // Save download in db

                    $db = new Database();
                    $sql = "DELETE FROM file WHERE filename = '" . $filesArray[$i]["name"] . "' AND path = '" . $filesArray[$i]["path"] . "'";
                    $db->query($sql);

                    $msg[] = array(
                        "name" => $filesArray[$i]["name"],
                        "path" => $filesArray[$i]["path"],
                        "message" => "File successfully deleted"
                    );

                } else {

                    // Folder or file couldn't be deleted

                    $msg[] = array(
                        "name" => $filesArray[$i]["name"],
                        "path" => $filesArray[$i]["path"],
                        "message" => "Folder or file couldn't be deleted"
                    );

                };

            };

            return (object) $msg;

        }

        /**
            * Get data for search
            * @param: $directory(string), $key(string)
            * @return: $files(object)
        */
        public static function getDataForSearch($directory, $key){

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

                        self::getDataForSearch($path, $key);

                    } else {

                        // File

                        if (preg_match("/" . $key . "/i", $file)){

                            self::$searchFiles[] = array(
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

            return (object) self::$searchFiles;

        }
		
	}

?>