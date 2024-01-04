<?php
session_start();

function generateRandomCode() {
    $numbers = '0123456789';
    $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < 3; $i++) {
        $randomString .= $numbers[rand(0, strlen($numbers) - 1)];
        $randomString .= $letters[rand(0, strlen($letters) - 1)];
    }

    return $randomString;
}

// generate a random code and save to session
$_SESSION['captcha'] = generateRandomCode();

// create an image
$image = imagecreate(140, 50);

// define colors for background and text
$background_color = imagecolorallocate($image, 255, 255, 255); // code background is white like web browser
$text_color = imagecolorallocate($image, 0, 200, 0); // code is shown in light green

// add the code to image (notice, code is accessed by '$_SESSION['captcha])
imagestring($image, 28, 50, 15, $_SESSION['captcha'], $text_color);

// send the image to web browser
header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>