<?php

require_once('dbConnection-B.php');

// start script
validateLogin();

function validateLogin() {
    // start session to receive global variables
    session_start();
    // make sure that post method is being used to avoid unnecessary bugs
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        http_response_code(403);
        error_log("Unexpected error occurred in login.php! It was not sent via POST method. \n", 3, "errorLog.txt");
        exit();
    }
    // bring email and password from loginForm POST protocol:
    $login_email = trim(filter_var($_POST["login-email"], FILTER_SANITIZE_EMAIL));
    $login_password = $_POST["login-password"];

    // Open database
    $conn = openDbConnection();
    // write a sql command that selects all columns of a row that has a specific email address
    $sql_command = "SELECT * FROM registrations WHERE email = :email";
    // prepare and execute a statement 
    $statement = $conn -> prepare($sql_command);
    $statement -> bindParam(':email', $login_email);
    $statement -> execute();



    //---------------------- PROBLEMS ------------------
    // if email was not found, alert user
    if ($statement -> rowCount() == 0) {
        http_response_code(401);
        exit();
    }

    // if email was found, take the password with associative chart
    // in associative chart column name works as key to value
    $user = $statement -> fetch(PDO::FETCH_ASSOC);


    // if email was found but given password is wrong, alert user
    if (!password_verify($login_password, $user['password'])) {
        http_response_code(402);
        exit();
    }

    // ------------------- LOGIN SUCCESSFULL!------------------------------
    // if stored password and now given password match, activate Login by storing it to session
    if(password_verify($login_password, $user['password'])) {
        activateLogin($user['ID']);
        http_response_code(201);
        exit();
    }

    //------------------UNEXPECTED PROBLEM---------------------------------------
    // if login.php is still on, there has happened a bug, alert user a bug has happened, add to error log and exit:
    $user_email = $user['email'];
    http_response_code(403);
    error_log("Unexpected error occurred in login.php! The user $user_email was unable to log in. \n", 3, "errorLog.txt");
    exit();

}

// store the login into session
function activateLogin($id) {
    // start session
    session_start();
    // create a global session varible for the id
    $_SESSION['user_id'] = $id;
    // store time of login as last activity
    $_SESSION['LAST_ACTIVITY'] = time();
    // expire time will be 1 hours = 1*60*60
    // so if person doesnt load any of the main pages for 1 hour, they must login again
    $_SESSION['expire_time'] = 1*60*60;
}


?>