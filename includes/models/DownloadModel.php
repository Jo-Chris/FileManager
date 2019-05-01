<?php

    /**
        * Class: DownloadModel
        * @function: downloadFile
    */

    class DownloadModel {

        /**
            * Download file
            * @param: $files(array)
        */
        public static function downloadFile($files){

            // Check if file exists

            $filesArray = json_decode($files, true);

            // Zip files, if greater than one file

            if (count($filesArray) > 1){

                // Multiple download

                $filename = "download.zip";

                // Create zip file

                $zip = new ZipArchive;

                if ($zip->open($filename, ZipArchive::CREATE) === TRUE){

                    // Add files to zip file

                    for ($i = 0; $i < count($filesArray); $i++){
                        if (file_exists($filesArray[$i]["path"] . "/" . $filesArray[$i]["name"])){
                            $zip->addFile($filesArray[$i]["path"] . "/" . $filesArray[$i]["name"]);
                        };
                    };

                };

                // Close zip archive

                $zip->close();

                // Download zip file

                header("Content-Type: application/zip");
                header("Content-Disposition: attachment; filename=" . basename($filename). "");
                header("Content-Length: " . filesize($filename));

                // Delete output puffer

                ob_end_clean();

                // Read file

                readfile($filename);

                // Delete file

                unlink($filename);

                exit;

            } else {

                // Single download

                if (file_exists($filesArray[0]["path"] . "/" . $filesArray[0]["name"])){

                    // Check if file or directory

                    if (is_file($filesArray[0]["path"] . "/" . $filesArray[0]["name"])){

                        // Write header for download

                        header("Content-Description: File Transfer");
                        header("Content-Type: application/octet-stream");
                        header("Content-Disposition: attachment; filename=" . basename($filesArray[0]["path"] . "/" . $filesArray[0]["name"]) . "");
                        header("Content-Transfer-Encoding: binary");
                        header("Connection: Keep-Alive");
                        header("Expires: 0");
                        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                        header("Pragma: public");
                        header("Content-Length: " . filesize($filesArray[0]["path"] . "/" . $filesArray[0]["name"]));

                        // Delete output puffer

                        ob_end_clean();

                        // Read file

                        readfile($filesArray[0]["path"] . "/" . $filesArray[0]["name"]);

                        exit;

                    };

                } else {

                    // Redirect to 404 error page

                    header("HTTP/1.0 404 Not Found", true, 404);
                    header("Location: " . URL_PATH . "/404");

                    exit;

                };

            };

        }

    }

?>