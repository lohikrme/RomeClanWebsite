<?php 

// before accepting registration, we validate name, email and passwords using 
// a separate script called 'validateRegistration.php'.

// Then, if everything is ok, we will open a database connection to our MySql db,
// and add the new user (line) there.

require_once ('validateRegistration.php'); // this checks name, email, password are ok
require_once ('dbConnection.php'); // this opens mysql database

// start the script
$registrationSuccessful = main();
if ($registrationSuccessful) {
    http_response_code(201);
}
else {
    http_response_code(400);
}

// main uses other methods to validate registration, confirm registration via email and to insert data into db
function main() {
    session_start(); // sstart session to receive captcha from session
    $registrationIsOK = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = trim(strip_tags($_POST["name"]));
        $email = trim(filter_var($_POST["email"], FILTER_SANITIZE_EMAIL));
        $password = $_POST["password"];

        $captcha_code = trim(strip_tags($_POST["captcha-code"]));

        if ($captcha_code != $_SESSION["captcha"]) {
            exit();
        }

        $registrationIsOK = validateRegistration($name, $email, $password);

        // if name, email and password are ok, hash the password, and store all variables into the database:
        if ($registrationIsOK) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $userAdded = AddUserToDB($name, $email, $hashed_password);
            // if registration is ok and user has been added succesfully, main function returns true
            if ($userAdded) {
                return true;
            }
            // if user is not added, main function returns false
            else  {
                return false;
            }
        }
        // if registration is not ok, main function returns false
        else {
            return false;
        }
    }
}


function addUserToDB($name, $email, $hashed_password) {

    // open connection to database
    $conn = openDbConnection();

    $date = date('Y-m-d H:i:s');

    try {

        // '$sql_command' variable stores the command to insert new values into the db's registration table: 
        $sql_command = "INSERT INTO registrations (email, name, password, date) VALUES (:email, :name, :password, :date)";

        // first prepare sql statement, then replace previous :email, :name and :password with their variables
        $statement = $conn -> prepare($sql_command);
        $statement -> bindParam(':email', $email);
        $statement -> bindParam(':name', $name);
        $statement -> bindParam(':password', $hashed_password);
        $statement -> bindParam(':date', $date);

        // now all good, just execute the sql statement, which inserts the data into the mysql database
        $statement -> execute();

        // user added successfully
        return true;
    } 
    
    catch(PDOException $e) {
        error_log("Mistake adding the user into database: " . $e->getMessage() . "\n", 3, "errorLog.txt");

        // adding user failed
        return false;
    }
}

?>