<?php

    /**
        * Class: DownloadModel
        * @function: downloadFile
    */

    class DownloadModel {

        /**
            * Download file
            * @param: $path(string), $name(string)
        */
        public static function downloadFile($path, $name){

            // Check if file exists

            if (file_exists($path . "/" . $name)){

                // Check if file or directory

                if (is_file($path . "/" . $name)){

                    // Write header for download

                    header("Content-Description: File Transfer");
                    header("Content-Type: application/octet-stream");
                    header("Content-Disposition: attachment; filename=" . basename($path . "/" . $name) . "");
                    header("Content-Transfer-Encoding: binary");
                    header("Connection: Keep-Alive");
                    header("Expires: 0");
                    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                    header("Pragma: public");
                    header("Content-Length: " . filesize($path . "/" . $name));

                    // Delete output puffer

                    ob_end_clean();

                    // Read file

                    readfile($path . "/" . $name);
                    exit;

                };

            } else {
                header("HTTP/1.0 404 Not Found", true, 404);
                header("Location: " . URL_PATH . "/404");
                exit;
            };

        }

    }

?>