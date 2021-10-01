<?php
    $servername = "localhost";
    $username = "francesco";
    $password = "some_pass";
    $db = "esoft";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    echo "Connected successfully";

?>