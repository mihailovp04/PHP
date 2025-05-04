<?php
/**
 * Database configuration
 * @return mysqli Database connection
 */
function getDBConnection() {
    $host = 'localhost';
    $dbname = 'vehicle_fleet';
    $username = 'root';
    $password = '';

    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>