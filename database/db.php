<?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "clinic_management_system";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
//}

$serverName = "localhost";
$dbName = "clinic_management_system";
$dbUser = "root";
$dbPassword = "";
try {
    $conn = new PDO("mysql:host=$serverName;dbname=$dbName", $dbUser, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>