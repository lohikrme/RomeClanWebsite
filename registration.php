<?php 

// here we send data inside our databases table "registrations".
// notice that ID will be auto-incremented inside db.

require_once 'dbConnection.php';
$conn = openDbConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    try {

        // '$sql_command' variable stores the command to insert new values into the db's registration table: 
        $sql_command = "INSERT INTO users (email, name, password) VALUES (:email, :name, :password)";


        $stmt = $conn -> prepare($sql_command);

        $stmt -> bindParam(':email', $email);
        $stmt -> bindParam(':name', $name);
        $stmt -> bindParam(':password', $password);

        $stmt -> execute();

        echo "<script>alert('Your registration has been succesful!');</script>";

        $ID_number += 1;
    } 
    
    catch(PDOException $e) {
        error_log("Virhe tietojen lisäämisessä: " . $e->getMessage() . "\n", 3, "errors.txt");
    }
}

?>