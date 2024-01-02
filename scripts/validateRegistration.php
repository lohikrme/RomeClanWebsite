<?php

require_once (__DIR__ . '/dbConnection.php'); 

// fetch variable data and run here other functions to validate them 
// if everything is fine, return true, so that registration.php can continue
function validateRegistration($name, $email, $password) {

    // check name is ok
    $nameIsNotEmpty = checkNameIsNotEmpty($name);
    $nameWithoutBannedLetters = checkNameWithoutBannedLetters($name);
    $nameIsNotTaken = checkNameIsNotTaken($name);

    // check email address is ok
    $emailIsNotEmpty = checkEmailIsNotEmpty($email);
    $emailWithoutBannedLetters = checkEmailWithoutBannedLetters($email);
    $emailIsNotTaken = checkEmailIsNotTaken($email);

    // check password is ok
    $passwordIsOk = checkPasswordIsOk($password);

    // check registrations table is not full:
    $registrationsHasRoom = checkRegistrationsHasRoom();

    // if everything is ok, return true
    if ($nameIsNotEmpty && $nameWithoutBannedLetters && $nameIsNotTaken && $emailIsNotEmpty && $emailWithoutBannedLetters && $emailIsNotTaken && $passwordIsOk && $registrationsHasRoom) {
        return true;
    }

    // if mistake in name, email or password was found, return false
    return false;
}


// -------------------------- HELPER FUNCTIONS ----------------------------------------------
// we will use these helper functions to identify the problem in user inputs
// we will use them also to validateRegistration
// If all these functions return true, then registration is valid


//-------------------VALIDATE----------------------------------
//---------------------NAME------------------------------------

// return false if name is empty
function checkNameIsNotEmpty($name) {
    if ($name == "") {
        return false;
    }
    return true;
}

// return false if name contains banned letters
function checkNameWithoutBannedLetters($name) {
    // compare $name to a list of letters - if some letters of $name are not inside the list, function will return false
    if (preg_match('/[^a-zA-Z0-9\s._-]/', $name)) {
        return false;
    }
    // if name is without banned letters return true
    return true;
}

// check name does not already exist inside the database's users - registration table
function checkNameIsNotTaken($name) {
    // open database connection
    $conn = openDbConnection();
    // prepare sql statement, replace :name with $name and then execute the statement
    $statement = $conn -> prepare("SELECT * FROM registrations WHERE name = :name");
    $statement -> bindParam(":name", $name);
    $statement -> execute();
    // if you can select more than 0 rows in the table, it means name already exists and return false
    if ($statement -> rowCount() > 0) {
        return false;
    }
    // if name is not found in db, return true
    return true;
}


//-------------------VALIDATE----------------------------------
//--------------------EMAIL------------------------------------

// return false if email is empty
function checkEmailIsNotEmpty($email) {
    if ($email == "") {
        return false;
    }
    return true;
}

// return false if email contains banned letters
function checkEmailWithoutBannedLetters($email) {
    // compare $email to a list of letters - if some letters of $email are not inside the list, function will return false
    if (preg_match('/[^a-zA-Z0-9\s._@-]/', $email)) {
        return false;
    }
    // if email is without banned letters return true
    return true;
}

// check email does not already exist inside the database's users - registration table
function checkEmailIsNotTaken($email) {
    // open database connection
    $conn = openDbConnection();
    // prepare sql statement, replace :email with $email and then execute the statement
    $statement = $conn -> prepare("SELECT * FROM registrations WHERE email = :email");
    $statement -> bindParam(":email", $email);
    $statement -> execute();
    // if you can select more than 0 rows in the table, it means email already exists and return false
    if ($statement -> rowCount() > 0) {
        return false;
    }
    // if email is not found in db, return true
    return true;
}

//-------------------VALIDATE----------------------------------
//-------------------PASSWORD----------------------------------

function checkPasswordIsOk($password) {
    // 1. make sure the password is not empty 
    // 2. length must be at least 10, must contain at least 1 large and 1 small letter and 1 number
    //    this is alrdy done by js script in register.html, but we dont want bugs with missing passwords...
    // 3. we cannot prevent that password does not contain hackering, because special letters must be allowed...
    //    but security is handled in registration.php by hashing the password before storing into the database

    // check if password is empty
    if ($password == "") {
        return false;
    }

    // check that password length is at least 10 letters,:
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


//-------------------REGISTRATIONS----------------------------------
//--------------------HAVE ROOM----------------------------------

function checkRegistrationsHasRoom() {
    // open database connection
    $conn = openDbConnection();
    // prepare and execute SQL statement
    $statement = $conn -> prepare("SELECT * FROM registrations");
    $statement -> execute();
    // if registrations table has over 10000 lines, do not allow registration
    if ($statement -> rowCount() > 10000) {
        return false;
    }
    // if all good allow registration
    return true;
}


?>