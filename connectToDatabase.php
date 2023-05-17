<?php
function connectToDatabase() {
    $servername = "localhost";
    $username = "test";
    $password = "test1234";
    $dbname = "attendance";

    // Create
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>
