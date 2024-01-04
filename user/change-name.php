<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <title>Document</title>
</head>
<body id="own-info">
    
<header>

    <div class="header-left">
        <img id="logo" src="../images/logo.png">
    </div>
    <div class="header-right">
        <h1>Rome Clan Website</h1>
        <ul class="menu-items-list">
            <li id="main-button"><a href="../index.php">Main</a></li>
            <li id="events-button"><a href="../events.php">Events</a></li>
            <li id="forum-button"><a href="../forum.php">Forum</a></li>
            <?php createLinkToOwnInformation(); ?> <!-- this script creates a link to users own information -->
            <?php createLogInButton(); ?> <!-- this script creates list-item that changes depending logged in or out -->
        </ul>
    </div>

</header>

<div class="textArea3">
    <p>You may change your name here.</p>
    <form>
        <div class="old-name">
            <label>Old Name: </label>
            <input type="email" placeholder="Nergi">
        </div>
        <br>
        <div class="new-name">
            <label>New Name: </label>
            <input type="email" placeholder="Igren">
        </div>
        <br>
        <div class="password">
            <label>Password:</label>
            <input type="password" placeholder="12345...">
        </div>
        <br>
        <div class="submit">
            <button id="submit" type="submit">Submit</button>
            <button id="clear" type="reset">Clear</button>
        </div>
    </form> 
</div>


<!-- next scripts activate jquery library, and then calls updateLoginStatus.php file
idea is to check if user should still stay logged in, and if need, log out -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $.ajax({
        url: 'scripts/updateLoginStatus-B.php',
        type: 'POST'
    });
});
</script>


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