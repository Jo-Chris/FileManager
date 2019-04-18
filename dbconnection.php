<?php

    $host = "localhost";
    $dbname = "filemanager";
    $user = "root";
    $pass = "";

    // DB connection
    $conn = mysqli_connect($host, $user, $pass);

    // Error, if database connection failed
    
    if (!$conn){
        die("Connection to the database failed!");
    };

    echo "Connected successfully";

?>