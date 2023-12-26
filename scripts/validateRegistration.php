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

function checkPasswords($password) {
    // make sure that password is not:
    // 1. empty 
    // 2. length must be at least 10, must contain at least 1 large and 1 small letter and 1 number
    //    this is alrdy done by js script in register.html, but we dont want bugs with missing passwords...
    // 3. we cannot prevent that password does not contain hackering, because special letters must be allowed...
    //    but security is handled by hashing the password (inside registration.php) before store into database

    // check if password is empty
    if ($password == "") {
        return false;
    }

    // check that password contains required 10 letters, 1 large, 1 small, 1 number:
    if (strlen($password) < 10) {
        return false;
    }

    // contains at least 1 large letter
    if (!preg_match('/[A-Z]/', $password)) {
        return false;
    }

    // contains at least 1 small letter
    if (!preg_match('/[a-z]/', $password)) {
        return false;
    }

    // contains at least 1 number
    if (!preg_match('/[0-9]/', $password)) {
        return false;
    }

    // if all good, return true
    return true;



}







?>