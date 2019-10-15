<?php
require_once '../../core/dbConnection.php';
require_once '../helpers/helpers.inc.php';
require_once "../models/Data.models.php";

/**
 * @param $email
 * @param $password
 * @return bool
 */
function login($email, $password)
{

    $result = fetchData($email, 'users', 'email');

    if (mysqli_num_rows($result) < 1) { //no email match
        return false;
    }

    $row = mysqli_fetch_assoc($result);
    if (!password_verify($password, $row['password'])) { // checking with pass
        return false;
    }

    $_SESSION['user_id'] = $row['id'];

    if (isset($_POST['remember'])) { // setting user cookie
        $rememberToken = generateRandomString();
        updateToken($rememberToken);
        setcookie('remember', $rememberToken, time() + 24 * 60 * 60, '/', 'localhost', false, true);
    }
    mysqli_free_result($result);
    return true;
}

/**
 * @param $rememberToken
 * @return bool
 */
function updateToken($rememberToken)
{
    global $connection;

    $userId = $_SESSION['user_id'];
    $query = "UPDATE users SET `remember`='$rememberToken' WHERE id='$userId'";
    try {
        mysqli_query($connection, $query) or throwException('Token update error');
    } catch (Exception $e) {
        echo $e->getMessage() . '<br>' . mysqli_error($connection) . '<br>';
        var_dump($e->getTrace()[0]);
    }
    return;

}

/**
 *
 */
function authenticateUserByCookie()
{

    $result = fetchData($_COOKIE['remember'], 'users', 'remember');

    if (mysqli_num_rows($result) < 1) { // remember token not found
        return;
    }

    $user = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $user['id'];
    return;
}


/**
 *
 */
function removeToken()
{
    global $connection;
    $userId = $_SESSION['user_id'];

    $query = "UPDATE users SET `remember`='' WHERE id='$userId";
    try {
        mysqli_query($connection, $query) or throwException('cant remove token');
    } catch (Exception $e) {
        echo $e->getMessage() . '<br>' . mysqli_error($connection) . '<br>';
        var_dump($e->getTrace()[0]);
    }
    return;
}
