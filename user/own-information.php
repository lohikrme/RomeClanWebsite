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
            <li id="main-button"><a href="../index.html">Main</a></li>
            <li id="events-button"><a href="../events.html">Events</a></li>
            <li id="forum-button"><a href="../forum.html">Forum</a></li>
            <li id="login-button"><a href="../login.html">Log in!</a></li>
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
                <td> trololoo </td>
            </tr>
            <tr>
                <td>Email: </td> 
                <td> trololoo </td>
            </tr>
            <tr>
                <td>Password: </td> 
                <td> ******** </td>
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
        url: 'scripts/updateLoginStatus.php', // korvaa 'scripts/updateLoginStatus.php' tiedostonimellä ja polulla, jossa päivität istunnon
        type: 'POST'
    });
});
</script>

</body>
</html>