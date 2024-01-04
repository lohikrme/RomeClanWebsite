<?php

function logOut() {
// start session, empty session variables, destroy session, move user to login page
session_start();
session_unset();
session_destroy();
header('Location: ../login.php');
exit();
}


?>