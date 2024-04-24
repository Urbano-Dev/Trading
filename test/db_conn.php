<?php

$db_username = 'root';
$db_password = '';
$db_name = 'database';

try {
    $conn = new PDO('mysql:host=localhost;dbname=' . $db_name . ';charset=utf8mb4', $db_username, $db_password);
    // Set PDO to throw exceptions on errors
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Use real prepared statements
    $conn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true); // Use buffered queries
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Throw exceptions on errors

    // Connection successful, continue with your code
} catch (PDOException $e) {
    // Connection error, display error message
    die("Connection failed: " . $e->getMessage());
}