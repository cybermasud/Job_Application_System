<?php
require_once '../models/Login.models.php';
if (!isset($come_from_controller)) {
    header('location:../controllers/SignUp.controller.php');
    exit();
} ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link href="../../assets/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="login">
    <h1>Please Enter Your Information</h1>
    <form action="../controllers/SignUp.controller.php?action=register&type=2" method="post">
        <!------------------------- User Inputs for sign up ------------------------>
        <input class="user" type="text" name="frm[name]" placeholder="Company Name">
        <?php if (!empty($_SESSION['err'][0])) : ?>
            <span class="error_sign">*</span>
        <?php endif ?>
        <!--------------------------------------------------------------------->
        <input class="user" type="tel" name="frm[tel]" placeholder="Telephone">
        <?php if (!empty($_SESSION['err'][1])) : ?>
            <span class="error_sign">*</span>
        <?php endif ?>
        <!--------------------------------------------------------------------->
        <input class="user" type="email" name="frm[email]" placeholder="Email">
        <?php if (!empty($_SESSION['err'][2])) : ?>
            <span class="error_sign">*</span>
        <?php endif ?>
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
        <input type="submit" name="submit" value="Sign Up">
        <!--------------------------------------------------------------------->
    </form>

    <ul class="error-messages">
        <?php foreach ($_SESSION['err'] as $key => $error): if (!empty($error[$key])): ?>
            <li><?= 'Field #' . ($key + 1) . ': ' . $error ?></li>
        <?php endif; endforeach; ?>
    </ul>

    <div class="error-messages">
        <?php if (!empty($_SESSION['signup'])) echo $_SESSION['signup']; ?>
    </div>

    <div class="link1">
        <a href="../controllers/Login.controller.php">Login Here</a>
    </div>
</div>
</body>
</html>

<?php
unset($_SESSION["err"]);
unset($_SESSION["signup"]);
?>
