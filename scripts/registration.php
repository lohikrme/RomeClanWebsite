<?php 

// here we send data inside our databases table "registrations".
// notice that ID will be auto-incremented inside db.

// also notice that we have already opened connection to users db,
// so this time we dont insert into users but into a table inside users
// the table is called "registrations"

require_once (__DIR__ . '/dbConnection.php');
$conn = openDbConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $name = $conn->quote($_POST["name"]);
    $password = $conn->quote($_POST["password"]);

    try {

        // '$sql_command' variable stores the command to insert new values into the db's registration table: 
        $sql_command = "INSERT INTO registrations (email, name, password) VALUES (:email, :name, :password)";


        $stmt = $conn -> prepare($sql_command);

        $stmt -> bindParam(':email', $email);
        $stmt -> bindParam(':name', $name);
        $stmt -> bindParam(':password', $password);

        $stmt -> execute();

        echo "<script>alert('Your registration has been succesful!');</script>";

        $ID_number += 1;
    } 
    
    catch(PDOException $e) {
        error_log("Virhe tietojen lisäämisessä: " . $e->getMessage() . "\n", 3, "errorLog.txt");
    }
}

?>