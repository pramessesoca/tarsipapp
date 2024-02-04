<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "user_authentication";

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo ""; 
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
