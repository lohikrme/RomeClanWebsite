<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <title>Document</title>
</head>
<body id="login">
    
<header>

    <div class="header-left">
        <img id="logo" src="images/logo.png">
    </div>
    <div class="header-right">
        <h1>Rome Clan Website</h1>
        <ul class="menu-items-list">
            <li id="main-button"><a href="index.php">Main</a></li>
            <li id="events-button"><a href="events.php">Events</a></li>
            <li id="forum-button"><a href="forum.php">Forum</a></li>
            <?php createLinkToOwnInformation(); ?> <!-- this script creates a link to users own information -->
            <?php createLogInButton(); ?> <!-- this script creates list-item that changes depending logged in or out -->
        </ul>
    </div>

</header>

<div class="textArea3">
    <p>You have been logged out!</p> 
</div>


<?php
// import logOut() function from logout-B.php file and then logout the user by
// destroying the current SESSION variables
require_once 'scripts/logout-B.php';
logOut();
?>



<!-- Next php script will transform login button to logout button if user has been logged in-->
<?php
function createLogInButton() {
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
    }

    // check if user is logged in (has SESSION variable called user_id):
    if (isset($_SESSION['user_id'])) { 
        // if user is logged in, login button reads log out! and clicking it logs user out
        echo '<li id="login-button"><a href="logged-out.php">Log out!</a></li>';
    } else {
        // user is not logged in, so use the original login-button, which already exists in html code
        echo '<li id="login-button"><a href="login.php">Log in!</a></li>';
    }
}
?>

<!-- Next php script creates an icon user can press to get to see and change their own information -->
<?php
function createLinkToOwnInformation() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['user_id'])) {
        echo "<a id='own-info-button' href='../user/own-information.php'><i class='fas fa-user'></i>Own Information</a>";
    }
}
?>

</body>
</html>