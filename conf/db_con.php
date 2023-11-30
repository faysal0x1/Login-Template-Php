<?php
//  Php database connection code using PDO

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "php_login";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

