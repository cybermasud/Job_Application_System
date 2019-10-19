<?php
require_once '../models/Login.models.php';

function setInputErrors($user_input, $type)
{
    if ($type === "1") { //user register form
        $_SESSION['err'][0] = validateName($user_input['name']);
        $_SESSION['err'][1] = validateName($user_input['family']);
        $_SESSION['err'][2] = validateTel($user_input['tel']);
        $_SESSION['err'][3] = validateEmail($user_input['email'], 'sign_up');
        $_SESSION['err'][4] = validateDate($user_input['birth_date']);
        $_SESSION['err'][5] = validateNumber($user_input['nationality']);
        $_SESSION['err'][6] = validateNumber($user_input['birth_place']);
        $_SESSION['err'][7] = validateGender($user_input['gender']);
        $_SESSION['err'][8] = validateNumber($user_input['degree']);
        $_SESSION['err'][9] = validateNumber($user_input['major']);
        $_SESSION['err'][10] = validateGpa($user_input['gpa']);
        $_SESSION['err'][11] = validateText($user_input['about']);
        $_SESSION['err'][13] = validateText($user_input['interests']);
        $_SESSION['err'][12] = validateText($user_input['skills']);
        $_SESSION['err'][26] = validateCaptcha($user_input['captcha']);

        $counter = 14; //initializing counter
        foreach ($user_input['company'] as $key => $value) { //looping employment history
            $_SESSION['err'][$counter] = validateText($value);
            if ($value !== '') {
                $_SESSION['err'][($counter + 1)] = validateDate($user_input['start_date'][$key]);
                $_SESSION['err'][($counter + 2)] = validateDate($user_input['end_date'][$key]);
                $_SESSION['err'][($counter + 3)] = validateText($user_input['reason'][$key]);
            }
            $counter += 4;
        }
    }
    if ($type === "2") { //company register form
        $_SESSION['err'][0] = validateName($user_input['name']);
        $_SESSION['err'][1] = validateTel($user_input['tel']);
        $_SESSION['err'][2] = validateEmail($user_input['email'], 'sign_up');
        $_SESSION['err'][3] = validateCaptcha($user_input['captcha']);
    }
    if ($type === "3") { //user update form
        $_SESSION['err'][] = validateName($user_input['name']);
        $_SESSION['err'][] = validateName($user_input['family']);
        $_SESSION['err'][] = validateDate($user_input['birth_date']);
        $_SESSION['err'][] = validateNumber($user_input['nationality']);
        $_SESSION['err'][] = validateNumber($user_input['birth_place']);
        $_SESSION['err'][] = validateGender($user_input['gender']);
        $_SESSION['err'][] = validateNumber($user_input['degree']);
        $_SESSION['err'][] = validateNumber($user_input['major']);
        $_SESSION['err'][] = validateGpa($user_input['gpa']);
        $_SESSION['err'][] = validateText($user_input['about']);
        $_SESSION['err'][] = validateText($user_input['interests']);
        $_SESSION['err'][] = validateText($user_input['skills']);
        $_SESSION['err'][24] = validateCaptcha($user_input['captcha']);

        $counter = 12; //initializing counter
        foreach ($user_input['company'] as $key => $value) { //looping employment history
            $_SESSION['err'][$counter] = validateText($value);
            if ($value !== '') {
                $_SESSION['err'][($counter + 1)] = validateDate($user_input['start_date'][$key]);
                $_SESSION['err'][($counter + 2)] = validateDate($user_input['end_date'][$key]);
                $_SESSION['err'][($counter + 3)] = validateText($user_input['reason'][$key]);
            }
            $counter += 4;
        }
    }


    if (count(array_filter($_SESSION['err']))) { //is there any error messages in session
        return false;
    } else {
        return true;
    }
}

function validateName($data)
{
    if ($data === '') {
        $alert = 'Field is Required';
        return $alert;
    }
    if (!preg_match('/^[^±`!@£$%^&*+§¡€#¢¶•ªº)(_\'\"«<>.?:;|=,]{3,20}$/', $data)) {
        $alert = 'Field can only contain letters, hyphen and must be between 3 and 20 characters';
        return $alert;
    }
    return;
}

function validateTel($data)
{
    if ($data === '') {
        $alert = 'Field is Required';
        return $alert;
    }
    if (!preg_match('/^(\+98|0)\d{10}$/', $data)) {
        $alert = 'enter a valid phone number';
        return $alert;
    }
    return;
}

function validateEmail($data, $page)
{
    if ($data === '') {
        $alert = 'Field is Required';
        return $alert;
    }
    if (!preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $data)) {
        $alert = 'Enter a Valid Email';
        return $alert;
    }
    $result = fetchData($data, "users", "email");
    if (mysqli_num_rows($result) > 0) { //email found
        if ($page === 'sign_up') {
            $alert = 'your Email Exists';
            return $alert;
        }
        if ($page === 'login') {
            return true;
        }
    } else { //email not found
        return;
    }
}

function validateDate($data)
{
    if ($data === '') {
        $alert = 'Field is Required';
        return $alert;
    }
    $pattern = '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/';
    if (!preg_match($pattern, $data)) {
        $alert = 'enter a valid date';
        return $alert;
    }
    return;

}

function validateNumber($data)
{
    if ($data === '') {
        $alert = 'Field is Required';
        return $alert;
    }
    if (!preg_match('/^[0-9]{1,5}$/', $data)) {
        $alert = 'enter a valid id';
        return $alert;
    }
    return;
}

function validateGender($data)
{
    if (empty($data)) {
        $alert = 'Field is Required';
        return $alert;
    }
    if (!preg_match('/^((fe)?male)$/', $data)) {
        $alert = 'enter a valid gender';
        return $alert;
    }
    return;
}

function validateGpa($data)
{
    if ($data === '') {
        $alert = 'Field is Required';
        return $alert;
    }
    if (!preg_match('/^[1-2]?\d\.?\d?$/', $data)) {
        $alert = 'enter a valid GPA';
        return $alert;
    }
    return;
}

function validateText($text)
{
    if (!preg_match('/^[A-Za-z0-9)\-(\'\":\s,]{0,1000}$/', $text)) {
        $alert = 'Do Not Use Special Chars and More than 1000 chars';
        return $alert;
    }
    return;
}

function validateCaptcha($captcha)
{
    if ($captcha != $_SESSION["answer"]) {
        $alert = "Inserted Captcha is Wrong";
        return $alert;
    }
    return;
}
