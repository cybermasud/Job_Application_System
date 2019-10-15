<?php
session_start();
require_once '../helpers/helpers.inc.php';
require_once '../models/SignUp.models.php';
require_once "../helpers/Validation.inc.php";

if ($_GET['type'] === "1" || $_GET['type'] === "2") { //defining user or company
    $type = $_GET['type'];
} else { //type is not defined
    header("location:Login.controller.php");
}

if ($_GET['action'] === 'register') { //checking if user clicked button
    doRegister($type);
} else if (isset($_SESSION['user_id'])) { //if user has been logged in go to dashboard
    header('location:UserDashboard.controller.php');
} else {
    showForm($type);
}

function showForm($type)
{
    $come_from_controller = true;
    $captcha = getCaptcha();
    $image = $captcha();
    imagepng($image,'captcha.png'); //image to be sent is png
    imagedestroy($image); //clearing cache
    if ($type === "1") {
        $nationality = fetchList('country');
        $birthplace = fetchList('city');
        $degree = fetchList('degree');
        $major = fetchList('major');
        require_once "../views/UserSignUp.views.php";
    }
    if ($type === "2") {
        require_once "../views/CompanySignUp.views.php";
    }
}

function doRegister($type)
{
    $user_input = fetchUserInput();
    $validation_result = setInputErrors($user_input, $type);

    if ($validation_result === true) {
        $password = generateRandomString(5);
        signUp($user_input, $password, $type);
        if (empty($_SESSION['signup'])) {
            $_SESSION['signup'] = 'Sign Up Successful' . ' and ' . 'Your Password is ' . $password;
        }
    }
    showForm($type);
}






