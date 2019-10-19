<?php
session_start();
require_once '../models/Login.models.php';

removeToken();
setcookie('remember', null, time() - 3600, '/');
session_unset();
session_destroy();
header('location:Login.controller.php');
exit();
