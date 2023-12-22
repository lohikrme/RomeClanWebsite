<?php

require_once (__DIR__ . '/dbConnection.php'); 

// fetch variable data and run here other functions to validate them 
// if everything is fine, return true, so that registration.php can continue
function validateRegistration($name, $email, $password1, $password2) {

    $nameIsValid = checkName($name);
    $emailIsValid = checkEmail($email);
    $passwordsAreValid = checkPasswords($password1, $password2);

    if ($nameIsValid && $emailIsValid && $passwordsAreValid) {
        return true;
    }

    return false;
}

function checkName($name) {
    // make sure that the name is not:
    // 1. empty 
    // 2. hackering
    // 3. already existing

    // check if name is empty
    if ($name == "") {
        return false;
    }
    // next letters may be related to SQL-injections or similar:
    else if (preg_match('/[\'^£$%&*()}{#~?><>,|=+¬-]/', $name)) {
        return false;
    }

    // find names from db and compare if already exists
    else {
        $conn = openDbConnection();

        // prepare sql statement. place '?' in place where $name should be
        // then use command bind_param, which replaces '?' with its second parameter
        // only then execute the sql statement and get its result
        $statement = $conn -> prepare("SELECT * FROM users WHERE name = ?");
        $statement -> bind_param("s", $name);
        $statement -> execute();
        $result = $statement -> get_result();

        // if sql statement found more than one row, that means name already exists:
        if ($result -> num_rows > 0) {
            return false;
        }

    }
    return true;
}



function checkEmail($email) {
    // make sure that the email is not:
    // 1. empty 
    // 2. hackering
    // 3. already existing

    // check if email is empty
    if ($email == "") {
        return false;
    }
    // next letters may be related to SQL-injections or similar:
    else if (preg_match('/[\'^£$%&*()}{#~?><>,|=+¬-]/', $email)) {
        return false;
    }

    // find emails from db and compare if already exists
    else {
        $conn = openDbConnection();

        // prepare sql statement. place '?' in place where $name should be
        // then use command bind_param, which replaces '?' with its second parameter
        // only then execute the sql statement and get its result
        $statement = $conn -> prepare("SELECT * FROM users WHERE email = ?");
        $statement -> bind_param("s", $email);
        $statement -> execute();
        $result = $statement -> get_result();

        // if sql statement found more than one row, that means name already exists:
        if ($result -> num_rows > 0) {
            return false;
        }

    }
    return true;

}

function checkPasswords($password1, $password2) {
    // make sure that both of the passwords are not:
    // 1. empty 
    // 2. hackering
    // 3. different between each others
    // 4. length must be at least 10, must contain at least 1 large and 1 small letter and 1 number
}







?>