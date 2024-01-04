
<?php

// this code connects the data flow from web site
// to database called "users" which i created in MySQL



function openDbConnection() {

    require_once ('passwords-B.php'); // import passwords, username, etc for database

    // notice array form: $name => $databaseUsername, $password => $databasePassword
    $nameAndPass = importDbNameAndPassword();

    $dsn = "mysql:host=localhost;dbname=users";
    $username = $nameAndPass['name'];
    $password = $nameAndPass['password'];
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