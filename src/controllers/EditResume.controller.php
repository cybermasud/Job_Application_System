<?php
//todo: resume edit request processed here with functions from resume models
//todo: show resume
//todo: edit and submit
//todo: show message on success or failure
session_start();
require_once "../helpers/LoginCheck.inc.php";
require_once "../models/Data.models.php";
require_once "../models/Resume.models.php";
require_once '../models/SignUp.models.php';
require_once "../helpers/Validation.inc.php";

if ($_GET['action'] === 'update') {
    doUpdateResume();
} else {
    showForm();
}

function showForm()
{
    $come_from_controller = true;

    //generating captcha
    $captcha = getCaptcha();
    $image = $captcha();
    imagepng($image, 'captcha.png'); //saving image
    imagedestroy($image); //clearing cache

    //fetching lists
    $nationality = fetchList('country');
    $birthplace = fetchList('city');
    $degree = fetchList('degree');
    $major = fetchList('major');

    //creating view and fetching data
    $view = createResumeViewForEdit();
    $resume = selectView($view);
    dropView($view);
    $companies = fetchCommaSeparatedData($resume['company']);
    $start_dates = fetchCommaSeparatedData($resume['start_date']);
    $end_dates = fetchCommaSeparatedData($resume['end_date']);
    $reasons = fetchCommaSeparatedData($resume['reason']);
    require_once "../views/EditResume.views.php";
}

function doUpdateResume()
{
    $user_input = fetchUserInput();
    $validation_result = setInputErrors($user_input, '3');
    if ($validation_result === true) {
        $status = updateResume($user_input);
        if ($status === true) {
            $_SESSION['edit'] = 'Resume Update Successful';
        } else {
            $_SESSION['edit'] = 'Something Went Wrong';
        }
    }
    showForm();
}