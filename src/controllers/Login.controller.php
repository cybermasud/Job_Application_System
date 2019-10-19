<?php
session_start();
require_once '../models/Login.models.php';
require_once '../helpers/helpers.inc.php';
require_once "../helpers/Validation.inc.php";

if (isset($_COOKIE['remember']) && !isset($_SESSION['user_id'])) {
    authenticateUserByCookie();
}

if ($_GET['action'] === 'login') { //checking if user clicked button
    doLogin();
} else if (isset($_SESSION['user_id'])) { //if user has been logged in go to dashboard
    header('location:Dashboard.controller.php');
} else {
    showForm();
}

function showForm()
{
    $captcha = getCaptcha();
    $image = $captcha();
    imagepng($image, 'captcha.png'); //saving image
    imagedestroy($image); //clearing cache
    $come_from_controller = true;
    require_once "../views/Login.views.php";
    exit;
}

function doLogin()
{
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $captcha = $_POST['captcha'] ?? '';
    $validation_result = validateEmail($email, 'login');
    if (is_string($validation_result)) {
        $_SESSION['error'] = $validation_result;
        showForm();
    }
    if (validateCaptcha($captcha) != '') {
        $_SESSION['error'] = 'Captcha is Wrong';
        showForm();
    }
    if (!login($email, $password)) {
        $_SESSION['error'] = 'Email or Password is Incorrect';
        showForm();
    } else {
        header('location:Dashboard.controller.php');
        exit();
    }

}


