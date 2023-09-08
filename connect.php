<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "library";

    $mysqli = new mysqli($server, $username, $password, $database);
    $mysqli->set_charset("utf8");

    if ($mysqli->connect_errno) {
        header("Location: ./error/");
        exit();
    }
?>