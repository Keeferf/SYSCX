<?php
    $server_name = 'localhost';
    $database_name = 'keefer_belanger_syscx';
    $username = 'keefer';
    $password = 'keefercarleton123';

    //Establish connection
    $conn = new mysqli($server_name, $username, $password, $database_name);
    if ($conn->connect_error) {
        die("Error: Couldn't connect." . $conn -> connect_error);
    }

    //Log connection
    $log_message = date("Y-m-d H:i:s") . " - Connected Successfully\n";
    $log_file = 'assets/connection_log.txt';
    file_put_contents($log_file, $log_message, FILE_APPEND);
?>