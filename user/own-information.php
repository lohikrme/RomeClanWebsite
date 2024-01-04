<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <title>Document</title>
</head>
<body>
    
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
            <?php createLogInButton(); ?> <!-- this script creates list-item that changes depending logged in or out -->
        </ul>
    </div>

</header>

<div class="textArea4">
    <p>This page shows your personal information! You may also change your name, email or password from here.</p> 
    <div class="own-info">
        <br>
        <table>
            <tr>
                <td>Name: </td> 
                <td>Nergi </td>
                <td><button onclick="window.location.href='change-name.php'">Change name</button></td>
            </tr>
            <tr>
                <td>Email: </td> 
                <td>warband.player@gmail.com </td>
                <td><button onclick="window.location.href='change-email.php'">Change email</button></td>
            </tr>
            <tr>
                <td>Password: </td> 
                <td>******** </td>
                <td><button onclick="window.location.href='change-password.php'">Change password</button></td>
            </tr>
        </table>
    </div>
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
    session_start(); // Aloita istunto

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

</body>
</html>