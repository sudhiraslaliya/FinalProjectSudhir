<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "yourfurniture";

// Function to establish a new connection
function getDBConnection() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Establish the initial connection
$conn = getDBConnection();
?>