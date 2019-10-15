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
    <form action="../controllers/SignUp.controller.php?action=register&type=1" method="post">
        <!------------------------- User Inputs for sign up ------------------------>
        <input class="user" type="text" name="frm[name]" placeholder="First Name">
        <?php if (!empty($_SESSION['err'][0])) : ?>
            <span class="error_sign">*</span>
        <?php endif ?>
        <!--------------------------------------------------------------------->
        <input class="user" type="text" name="frm[family]" placeholder="Last Name">
        <?php if (!empty($_SESSION['err'][1])) : ?>
            <span class="error_sign">*</span>
        <?php endif ?>
        <!--------------------------------------------------------------------->
        <input class="user" type="tel" name="frm[tel]" placeholder="Telephone">
        <?php if (!empty($_SESSION['err'][2])) : ?>
            <span class="error_sign">*</span>
        <?php endif ?>
        <!--------------------------------------------------------------------->
        <input class="user" type="email" name="frm[email]" placeholder="Email">
        <?php if (!empty($_SESSION['err'][3])) : ?>
            <span class="error_sign">*</span>
        <?php endif ?>
        <!--------------------------------------------------------------------->
        <fieldset>
            <legend>Personal Information</legend>
            <label>
                Birth Date
                <input type="date" name="frm[birth_date]">
            </label>
            <?php if (!empty($_SESSION['err'][4])) : ?>
                <span class="error_sign">*</span>
            <?php endif ?>
            <!--------------------------------------------------------------------->
            <label>Nationality
                <select name="frm[nationality]">
                    <option disabled selected> -- Select Your Country --</option>
                    <?php foreach ($nationality as $key => $value): ?>
                        <option value=<?= ($key + 1); ?>><?= $value[0]; ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <?php if (!empty($_SESSION['err'][5])) : ?>
                <span class="error_sign">*</span>
            <?php endif ?>
            <!--------------------------------------------------------------------->
            <label>Birth Place
                <select name="frm[birth_place]">
                    <option disabled selected> -- Select Your Birth Place --</option>
                    <?php foreach ($birthplace as $key => $value): ?>
                        <option value=<?= ($key + 1); ?>><?= $value[0]; ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <?php if (!empty($_SESSION['err'][6])) : ?>
                <span class="error_sign">*</span>
            <?php endif ?>
            <!--------------------------------------------------------------------->
            <fieldset>
                <legend>Gender</legend>
                <label>
                    Male<input type="radio" name="frm[gender]" value="male" checked>
                </label>
                <label>
                    Female<input type="radio" name="frm[gender]" value="female">
                </label>
            </fieldset>
            <?php if (!empty($_SESSION['err'][7])) : ?>
                <span class="error_sign">*</span>
            <?php endif ?>
            <!--------------------------------------------------------------------->
            <fieldset>
                <legend>Education</legend>
                <label>Degree
                    <select name="frm[degree]">
                        <option disabled selected> -- Select Your Degree Type --</option>
                        <?php foreach ($degree as $key => $value): ?>
                            <option value=<?= ($key + 1); ?>><?= $value[0]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <?php if (!empty($_SESSION['err'][8])) : ?>
                    <span class="error_sign">*</span>
                <?php endif ?>
                <label>Major
                    <select name="frm[major]">
                        <option disabled selected> -- Select Your Major --</option>
                        <?php foreach ($major as $key => $value): ?>
                            <option value=<?= ($key + 1); ?>><?= $value[0]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <?php if (!empty($_SESSION['err'][9])) : ?>
                    <span class="error_sign">*</span>
                <?php endif ?>
                <label>GPA
                    <input type="number" name="frm[gpa]" min="0" max="20" step="0.1">
                </label>
                <?php if (!empty($_SESSION['err'][10])) : ?>
                    <span class="error_sign">*</span>
                <?php endif ?>
            </fieldset>
            <fieldset>
                <legend>A Few Words About Yourself</legend>
                <input class="user" type="text" name="frm[about]" placeholder="About Yourself">
                <?php if (!empty($_SESSION['err'][11])) : ?>
                    <span class="error_sign">*</span>
                <?php endif ?>
            </fieldset>
            <fieldset>
                <legend>Your Skills</legend>
                <input class="user" type="text" name="frm[skills]" placeholder="Your Skills Separated with Comma">
                <?php if (!empty($_SESSION['err'][12])) : ?>
                    <span class="error_sign">*</span>
                <?php endif ?>
            </fieldset>
            <fieldset>
                <legend>Your Interests</legend>
                <input class="user" type="text" name="frm[interests]" placeholder="Your Interests Separated with Comma">
                <?php if (!empty($_SESSION['err'][13])) : ?>
                    <span class="error_sign">*</span>
                <?php endif ?>
            </fieldset>
        </fieldset>
        <!--------------------------------------------------------------------->
        <fieldset>
            <legend>Last Three Employment Details</legend>
            <label>Company 1
                <input type="text" name="frm[company][0]">
            </label>
            <?php if (!empty($_SESSION['err'][14])) : ?>
                <span class="error_sign">*</span>
            <?php endif ?>
            <label>Start Date
                <input type="date" name="frm[start_date][0]">
            </label>
            <?php if (!empty($_SESSION['err'][15])) : ?>
                <span class="error_sign">*</span>
            <?php endif ?>
            <label>End Date
                <input type="date" name="frm[end_date][0]">
            </label>
            <?php if (!empty($_SESSION['err'][16])) : ?>
                <span class="error_sign">*</span>
            <?php endif ?>
            <label>Reason of Leaving
                <input type="text" name="frm[reason][0]">
            </label>
            <?php if (!empty($_SESSION['err'][17])) : ?>
                <span class="error_sign">*</span>
            <?php endif ?>
            <br>
            <label>Company 2
                <input type="text" name="frm[company][1]">
            </label>
            <?php if (!empty($_SESSION['err'][18])) : ?>
                <span class="error_sign">*</span>
            <?php endif ?>
            <label>Start Date
                <input type="date" name="frm[start_date][1]">
            </label>
            <?php if (!empty($_SESSION['err'][19])) : ?>
                <span class="error_sign">*</span>
            <?php endif ?>
            <label>End Date
                <input type="date" name="frm[end_date][1]">
            </label>
            <?php if (!empty($_SESSION['err'][20])) : ?>
                <span class="error_sign">*</span>
            <?php endif ?>
            <label>Reason of Leaving
                <input type="text" name="frm[reason][1]">
            </label><?php if (!empty($_SESSION['err'][21])) : ?>
                <span class="error_sign">*</span>
            <?php endif ?><br>
            <label>Company 3
                <input type="text" name="frm[company][2]">
            </label>
            <?php if (!empty($_SESSION['err'][22])) : ?>
                <span class="error_sign">*</span>
            <?php endif ?>
            <label>Start Date
                <input type="date" name="frm[start_date][2]">
            </label>
            <?php if (!empty($_SESSION['err'][23])) : ?>
                <span class="error_sign">*</span>
            <?php endif ?>
            <label>End Date
                <input type="date" name="frm[end_date][2]">
            </label>
            <?php if (!empty($_SESSION['err'][24])) : ?>
                <span class="error_sign">*</span>
            <?php endif ?>
            <label>Reason of Leaving
                <input type="text" name="frm[reason][2]">
            </label>
            <?php if (!empty($_SESSION['err'][25])) : ?>
                <span class="error_sign">*</span>
            <?php endif ?>
        </fieldset>
        <fieldset>
            <p>Enter Number as Answer for Equation or Case Sensitive Alphanumeric Chars or Pictures Description</p>
            <div>
                <input type="text" name="frm[captcha]" placeholder="Enter Captcha Below">
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
        <?php if (!empty($_SESSION['signup'])): ?>
            <span><?= $_SESSION['signup'] ?></span>
        <?php endif; ?>
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

