<?php 

// before accepting registration, we validate name, email and passwords using 
// a separate script called 'validateRegistration.php'.

// Then, if everything is ok, we will open a database connection to our MySql db,
// and add the new user (line) there.

require_once ('validateRegistration-B.php'); // this checks name, email, password are ok
require_once ('dbConnection-B.php'); // this opens mysql database

// start the script
main();

// main uses other methods to validate registration, confirm registration via email and to insert data into db
function main() {
    session_start(); // sstart session to receive captcha from session
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = trim(strip_tags($_POST["name"]));
        $email = trim(filter_var($_POST["email"], FILTER_SANITIZE_EMAIL));
        $password = $_POST["password"];

        $captcha_code = trim(strip_tags($_POST["captcha-code"]));

        // if user writes a wrong captcha code, info user and exit:
        if ($captcha_code != $_SESSION["captcha"]) {
            http_response_code(406);
            exit();
        }

        // check if name, email and password are ok:
        $registrationInputsAreOK = validateRegistration($name, $email, $password);

        // if name, email and password are ok, hash the password, and store all variables into the database:
        if ($registrationInputsAreOK) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $userAdded = AddUserToDB($name, $email, $hashed_password);
            // if registration is ok and user has been added succesfully, info user and exit code:
            if ($userAdded) {
                http_response_code(201);
                exit();
            }
            // if for some reason we were not able to add user, info user there is some problem and ask them to try again later:
            else  {
                http_response_code(407);
                exit();
            }
        }
        // if name, email or password are banned, check out in order what is the problem and info the user:
        else {
            // check if name is empty and alert user
            $nameIsNotEmpty = checkNameIsNotEmpty($name);
            if ($nameIsNotEmpty == false) {
                http_response_code(401);
                exit();
            }
            // check if name contains banned letters and alert user
            $nameWithoutBannedLetters = checkNameWithoutBannedLetters($name);
            if ($nameWithoutBannedLetters == false) {
                http_response_code(401);
                exit();
            }
            // check if name is already taken and alert user
            $nameIsNotTaken = checkNameIsNotTaken($name);
            if ($nameIsNotTaken == false) {
                http_response_code(402);
                exit();
            }
            // check if email address is empty and alert user
            $emailIsNotEmpty = checkEmailIsNotEmpty($email);
            if ($emailIsNotEmpty == false) {
                http_response_code(403);
                exit();
            }
            // check if email address contains banned letters and alert user
            $emailWithoutBannedLetters = checkEmailWithoutBannedLetters($email);
            if ($emailWithoutBannedLetters == false) {
                http_response_code(403);
                exit();
            }
            // check if email address is already taken and alert user
            $emailIsNotTaken = checkEmailIsNotTaken($email);
            if ($emailIsNotTaken == false) {
                http_response_code(404);
                exit();
            }

            // check if password has issues and alert the user
            $passwordIsOk = checkPasswordIsOk($password);
            if ($passwordIsOk == false) {
                http_response_code(405);
                exit();
            }

            // check if database table registrations is full and alert the user
            $registrationsHasRoom = checkRegistrationsHasRoom();
            if ($registrationsHasRoom == false) {
                http_response_code(407);
                error_log("Mistake adding user into database: Database is FULL! \n", 3, "errorLog.txt");
                exit();
            }
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