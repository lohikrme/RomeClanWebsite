
<?php

checkIfUserStillLoggedIn();

// this function updates last activity time, and if expire time has been reached, logs out the user
// idea is to observe is user should stay logged in or not
function checkIfUserStillLoggedIn() {

    // start session to access session variables
    session_start();

    // make sure the login session variables exist = user is logged in, otherwise exit
    if (!isset($_SESSION['LAST_ACTIVITY']) or  !isset($_SESSION['expire_time'])) {
        exit();
    }

    // check if login session has expired
    // if expired, destroy the current session, and move user to login.html page
    if (time() - $_SESSION['LAST_ACTIVITY'] > $_SESSION['expire_time']) {
        session_unset();
        session_destroy();
        header('Location: ../login.html');
        exit();
    } 
}

?>