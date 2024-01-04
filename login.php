<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/login.css">
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

<form class="loginForm" action="scripts/login.php" method="post">
    <h2>Login here! </h2>
    
    <p class="loginTexts">Email Address: </p>
    <div>
        <label><i class="fas fa-user"></i></label>
        <input class="inputs" id="login-email-input" type="text" placeholder="warband.player@gmail.com" name="login-email"> 
    </div>

    <p class="loginTexts">Password: </p>
    <div>
        <label><i class="fas fa-lock"></i></label>
        <input class="inputs" id="login-password-input" type="password" placeholder="12345" name="login-password"> 
    </div>

    <br>

    <button class="buttons1" id="send-form-button">Login</button>
    <button class="buttons1" id="clear-button">Clear</button> <br>
    <a class="buttons2" id="register-button" href="register.php">Dont have an account yet? </a>
    <a class="buttons2" id="forgot-password-button" href="login.php">Forgot password? </a>
</form> <!-- loginForm ends -->





<script>
    // this script listens if forgot-password-button is pressed, and gives user
    // an alert that tells to contact support at rome.lh.bl@gmail.com
    document.getElementById('forgot-password-button').addEventListener('click', function(event) {
        alert("If you have forgotten password, please contact support at address rome.lh.bl@gmail.com. Please send the message from the same email address that you used to registeration.")
    });
</script>

<script>
    // we use this script to send login data forward to the login.php file
    // while not changing the page... if there are problems
    // such as no email found, we will receive a HTTP status
    // from the php file and we will alert the user correspondingly
    document.getElementById('send-form-button').addEventListener('click', function(event) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'scripts/login-B.php', true);
        var formData = new FormData(document.querySelector('.loginForm'));
        xhr.send(formData);
        // wait asynchronously until php responds...
        xhr.onload = function() {
            // if login has been successful open a new page...
            if (xhr.status == 201) {
                window.location.href = "logged-in.php";
            }
            // if email was not found alert user
            if (xhr.status == 401) {
                alert("EMAIL was not found. Maybe a typo? Or maybe not registered yet? Contact rome.lh.bl@gmail.com if the problem persists...");
            }
            // if email was found, but given password does not match it
            if (xhr.status == 402) {
                alert("PASSWORD is wrong! Your email address has registered an account, but the password you gave is wrong. If you have forgotten your password, please send email to rome.lh.bl@gmail.com");
            }
            // if unexpected error occurred
            if (xhr.status == 403) {
                alert("An unexpected ERROR occurred. Please try again later. If problem persists, send email to rome.lh.bl@gmail.com");
            }
        }
        // prevent the default way of sending form with POST protocol to avoid opening the php file
        event.preventDefault();
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

