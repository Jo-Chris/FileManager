<?php

    include_once "./includes/classes/Mail.php";

    $mail = new Mail("Test", "info@manuelseisl.at", "info@manuelseisl.at", "Hallo", "info@manuelseisl.at");
    $mail->send();

?>