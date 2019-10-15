<?php
require_once '../models/Login.models.php';

if (!isset($come_from_controller)) {
    header('location:../controllers/Login.controller.php');
    exit();
} ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link href="../../assets/css/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    </head>
    <body>
    <div class="login">
        <h1>Please Enter Your Credentials</h1>
        <form action="../controllers/Login.controller.php?action=login" method="post">
            <!---------------------------- User Inputs for Login -------------------------->
            <label for="username">
                <i class="fas fa-user"></i>
            </label>
            <input class="user" type="email" name="email" placeholder="Email" required>
            <!--------------------------------------------------------------------->
            <label for="password">
                <i class="fas fa-lock"></i>
            </label>
            <input class="user" type="password" name="password" placeholder="Password" required>
            <!--------------------------------------------------------------------->
            <div>
                Remember Me <input type="checkbox" name="remember">
            </div>
            <!--------------------------------------------------------------------->
            <fieldset>
                <p>Enter Number as Answer for Equation or Case Sensitive Alphanumeric Chars or Pictures Description</p>
                <div>
                    <input type="text" name="captcha" placeholder="Enter Captcha Below">
                </div>
                <div>
                    <img src="captcha.png" alt="captcha">
                </div>
            </fieldset>
            <!--------------------------------------------------------------------->
            <input type="submit" value="Login">
            <!--------------------------------------------------------------------->
            <?php if (!empty($_SESSION['error'])) : ?>
                <p class="login-error"><?= $_SESSION['error'] ?></p>
            <?php endif ?>

        </form>
        <div class="link">
            <a href="../controllers/SignUp.controller.php?type=1">Job Seeker Sign Up</a>
            <a href="../controllers/SignUp.controller.php?type=2">Company Sign Up</a>
        </div>
    </div>
    </body>
    </html>
<?php
unset($_SESSION["error"]);
?>