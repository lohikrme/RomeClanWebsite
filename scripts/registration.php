<?php 

// before accepting registration, we validate name, email and passwords using 
// a separate script called 'validateRegistration.php'.

// Then, if everything is ok, we will open a database connection to our MySql db,
// and add the new user (line) there.

require_once (__DIR__ . 'validateRegistration');
require_once (__DIR__ . '/dbConnection.php');

function main() {
    $registrationIsOK = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = trim(strip_tags($_POST["name"]));
        $email = trim(filter_var($_POST["email"], FILTER_SANITIZE_EMAIL));
        $password = $_POST["password"];

        // passwords cannot be stripped from tags and special letters, 
        // so instead we must hash them, and then store safely
        $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

        $registrationIsOK = validateRegistration($name, $email, $hashed_password);

        if ($registrationIsOK) {
            AddDataToDB();
        }

    }
}


function addDataToDB() {
    $conn = openDbConnection();

    try {

        // '$sql_command' variable stores the command to insert new values into the db's registration table: 
        $sql_command = "INSERT INTO registrations (email, name, password) VALUES (:email, :name, :password)";


        $stmt = $conn -> prepare($sql_command);

        $stmt -> bindParam(':email', $email);
        $stmt -> bindParam(':name', $name);
        $stmt -> bindParam(':password', $password);

        $stmt -> execute();

        echo "<script>alert('Your registration has been succesful!');</script>";
    } 
    
    catch(PDOException $e) {
        error_log("Virhe tietojen lisäämisessä: " . $e->getMessage() . "\n", 3, "errorLog.txt");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Hello</p>
</body>
</html>