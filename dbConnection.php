<?php
function openDbConnection() {
    $dsn = "mysql:host=localhost;dbname=users";
    $username = "root";
    $password = "";
    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        error_log("Connection failed: " . $e->getMessage() . "\n", 3, "errorLog.txt");
    }
}
?>