<?php
//todo: main page controller, handles dashboard contents with functions from resume models
//todo: show request sent items
//todo: show related companies
//todo: send resume for selected company and show message sent or failed
if (isset($_COOKIE['remember']) && !isset($_SESSION['user_id'])) {
    authenticateUserByCookie();
}
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === '1') {
    showUserDashboard();
} else if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === '2') {
    showCompanyDashboard();
} else if ($_GET['action'] === 'send') {
    sendJobRequest();
} else {
    header('location:Login.controller.php');
}

function showUserDashboard()
{
    $come_from_controller = true;
    require_once "../views/UserDashboard.views.php";
    exit;
}

function showCompanyDashboard()
{
    $come_from_controller = true;
    require_once "../views/CompanyDashboard.views.php";
    exit;
}

function sendJobRequest()
{

}