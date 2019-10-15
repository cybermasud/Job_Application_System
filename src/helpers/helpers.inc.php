<?php

function throwException($message = NULL, $code = NULL)
{
    throw new Exception($message, $code);
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function captcha1($length = 5)
{
    $image = imagecreatetruecolor(200, 50); //creating raw image

    $background_color = imagecolorallocate($image, 255, 255, 255);
    imagefilledrectangle($image, 0, 0, 200, 50, $background_color);

    $line_color = imagecolorallocate($image, 64, 64, 64); //adding lines
    for ($i = 0; $i < 10; $i++) {
        imageline($image, 0, rand() % 50, 200, rand() % 50, $line_color);
    }

    $pixel_color = imagecolorallocate($image, 0, 0, 255);//adding pixels
    for ($i = 0; $i < 1000; $i++) {
        imagesetpixel($image, rand() % 200, rand() % 50, $pixel_color);
    }
    $font = [dirname(__FILE__) . '/../../assets/fonts/times_new_yorker.ttf']; //setting font
    $text_color = imagecolorallocate($image, 0, 0, 0); //color of captcha
    $string = generateRandomString(5);
    imagettftext($image, 24, rand(-10, 10), 45, 35, $text_color, $font[0], $string); //transforming string into image with different styles
    $_SESSION["answer"] = $string;
    return $image;
}

function captcha2()
{
    $operators = array("+", "*", "-");
    $numbers = array("zero", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine");
    $key1 = array_rand($numbers);
    $key2 = array_rand($operators);
    $key3 = array_rand($numbers);
    $captcha = $numbers[$key1] . " " . $operators[$key2] . " " . $numbers[$key3];
    $oprand1 = (int)$key1;
    $oprand2 = (int)$key3;
    switch ($key2) {
        case "0":
            $answer = $oprand1 + $oprand2;
            break;
        case "1":
            $answer = $oprand1 * $oprand2;
            break;
        case "2":
            $answer = $oprand1 - $oprand2;
            break;
    }
    $image = imagecreatetruecolor(200, 50); //creating raw image

    $background_color = imagecolorallocate($image, 255, 255, 255);
    imagefilledrectangle($image, 0, 0, 200, 50, $background_color);

    $line_color = imagecolorallocate($image, 64, 64, 64); //adding lines
    for ($i = 0; $i < 10; $i++) {
        imageline($image, 0, rand() % 50, 200, rand() % 50, $line_color);
    }

    $pixel_color = imagecolorallocate($image, 0, 0, 255);//adding pixels
    for ($i = 0; $i < 1000; $i++) {
        imagesetpixel($image, rand() % 200, rand() % 50, $pixel_color);
    }
    $font = [dirname(__FILE__) . '/../../assets/fonts/times_new_yorker.ttf']; //setting font
    $text_color = imagecolorallocate($image, 0, 0, 0); //color of text

    imagettftext($image, 24, rand(-10, 10), (35 + random_int(-30, 30)), 35, $text_color, $font[0], $captcha); //transforming string into image with different styles
    $_SESSION["answer"] = (string)$answer;
    return $image;
}


function getCaptcha() //random captcha
{
    $functions = array("captcha1", "captcha2");
    $random_key = array_rand($functions);
    return $functions[$random_key];
}