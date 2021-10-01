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

    $res = $conn->query('CREATE TABLE task (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name char(255),
        description text,
        priority char(255),
        status char(255),
        author INT(11),
        executor INT(11),
        start_date date,
        end_date date,
        update_date	datetime
    )');
?>