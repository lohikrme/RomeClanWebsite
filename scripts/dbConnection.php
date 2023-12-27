
<?php

// this code connects the data flow from web site
// to database called "users" which i created in MySQL



function openDbConnection() {

    require_once (__DIR__ . 'passwords.php'); // import passwords, username, etc for database

    $dsn = "mysql:host=localhost;dbname=users";
    $username = $database_username;
    $password = $database_password;
    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } 
    catch(PDOException $e) {
        error_log("Connection failed: " . $e->getMessage() . "\n", 3, "errorLog.txt");
    }
}
?>