<?php
$serverName = "localhost";
$userName = "root";
$password = "";
$database = "tutorials";

try {
    $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo 'connect to database';
} catch (PDOException $e) {
    echo 'ERROR' . $e->getMessage() . '<br/>';
}