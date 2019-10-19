<?php
require_once "../models/Data.models.php";
require_once '../helpers/helpers.inc.php';
/**
 * @param $user_input
 * @param $password
 * @param $type
 * @throws Exception
 */
function signUp($user_input, $password, $type)
{
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if ($type === "1") { //type is jobseeker

        $user_id = insertUser($user_input['email'], $hashed_password, $user_input['tel'], $type);
        if ($user_id === false) {
            return false;
        }
        $status = insertEducation($user_id, $user_input['major'], $user_input['degree'], $user_input['gpa']);
        if ($status === false) {
            return false;
        }
        $status = insertUserProfile($user_id, $user_input['name'], $user_input['family'], $user_input['gender'], $user_input['birth_date'], $user_input['about'], $user_input['birth_place'], $user_input['nationality']);
        if ($status === false) {
            return false;
        }
        $status = insertEmploymentHistory($user_input['company'], $user_input['start_date'], $user_input['end_date'], $user_input['reason'], $user_id);
        if ($status === false) {
            return false;
        }
        $status = insertSkill($user_input['skills'], $user_id);
        if ($status === false) {
            return false;
        }
        $status = insertInterest($user_input['interests'], $user_id);
        if ($status === false) {
            return false;
        }
    }
    if ($type === "2") { //type is company

        $user_id = insertUser($user_input['email'], $hashed_password, $user_input['tel'], $type);
        if ($user_id === false) {
            return false;
        }
        $status = insertCompanyProfile($user_id, $user_input['name']);
        if ($status === false) {
            return false;
        }
    }
    return true;
}

function insertCompanyProfile($user_id, $name)
{
    global $connection;

    $query = "INSERT INTO `company_profile`(`user_id`, `name`) VALUES ('$user_id','$name')";
    try {
        $result = mysqli_query($connection, $query) or throwException('cant insert company');

    } catch (Exception $e) {
        echo $e->getMessage() . '<br>' . mysqli_error($connection) . '<br>';
        var_dump($e->getTrace()[0]);
        return false;
    } finally {
        mysqli_free_result($result);
    }

    return true;
}

function insertUser($email, $password, $tel, $type)
{
    global $connection;

    $query = "INSERT INTO `users`(`email`, `password`, `tel`, `type`) VALUES ('$email','$password','$tel','$type')";
    try {
        $result = mysqli_query($connection, $query) or throwException('cant insert user');
    } catch (Exception $e) {
        echo $e->getMessage() . '<br>' . mysqli_error($connection) . '<br>';
        var_dump($e->getTrace()[0]);
        return false;
    } finally {
        mysqli_free_result($result);
    }
    $user_id = mysqli_insert_id($connection);
    return $user_id;
}

function insertEducation($user_id, $major, $degree, $gpa)
{
    global $connection;

    $query = "INSERT INTO `education`(`user_id`, `major_id`, `degree_id`, `GPA`) VALUES ($user_id,'$major','$degree','$gpa')";
    try {
        $result = mysqli_query($connection, $query) or throwException('cant insert education');
    } catch (Exception $e) {
        echo $e->getMessage() . '<br>' . mysqli_error($connection) . '<br>';
        var_dump($e->getTrace()[0]);
        return false;
    } finally {
        mysqli_free_result($result);
    }
    return true;
}

function insertUserProfile($user_id, $name, $family, $gender, $birth_date, $about, $birth_place, $nationality)
{
    global $connection;

    $query = "INSERT INTO `user_profile`(`user_id`, `firstname`, `lastname`, `gender`, `birthdate`, `about`, `birthcity_id`, `nationaity_id`) VALUES ('$user_id' ,'$name','$family','$gender','$birth_date','$about','$birth_place','$nationality')";
    try {
        $result = mysqli_query($connection, $query) or throwException('cant insert profile');
    } catch (Exception $e) {
        echo $e->getMessage() . '<br>' . mysqli_error($connection) . '<br>';
        var_dump($e->getTrace()[0]);
        return false;
    } finally {
        mysqli_free_result($result);
    }
    return true;
}

/**
 * @param $user_input
 * @param $user_id
 * @throws Exception
 */
function insertInterest($user_input, $user_id)
{
    $interest_array = (fetchCommaSeparatedData($user_input)); //skills or interests input converted to array
    if (empty($interest_array)) { //is there any inputs
        return;
    }
    global $connection;
    foreach ($interest_array as $value) { //looping in array
        $result = fetchData($value, 'interest', "name"); //selecting values from table
        if (mysqli_num_rows($result) < 1) { // no value found and adding values into table and creating array of id's
            $query = "INSERT INTO interest (`name`) VALUES ('$value')";
            try {
                mysqli_query($connection, $query) or throwException('cant insert interest');
            } catch (Exception $e) {
                echo $e->getMessage() . '<br>' . mysqli_error($connection) . '<br>';
                var_dump($e->getTrace()[0]);
                return false;
            }
            $interest_ids[] = mysqli_insert_id($connection);
        } else { // value found and creating array of id's
            $interest_ids[] = mysqli_fetch_assoc($result)['id'];
        }
    }
    $query = '';
    foreach ($interest_ids as $id) { //building queries
        $query .= "INSERT INTO user_has_interest (`user_id`,`interest_id`) VALUES ('$user_id',$id);";
    }

    try {
        mysqli_multi_query($connection, $query) or throwException('cant insert multi interest');
        do {
            $result = mysqli_store_result($connection);
            mysqli_free_result($result);
        } while (mysqli_next_result($connection));
    } catch (Exception $e) {
        echo $e->getMessage() . '<br>' . mysqli_error($connection) . '<br>';
        var_dump($e->getTrace()[0]);
        return false;
    }
    return true;
}

function insertSkill($user_input, $user_id)
{
    $skill_array = (fetchCommaSeparatedData($user_input)); //skills or interests input converted to array
    if (empty($skill_array)) { //is there any inputs
        return;
    }
    global $connection;
    foreach ($skill_array as $value) { //looping in array
        $result = fetchData($value, 'skill', "name"); //selecting values from table
        if (mysqli_num_rows($result) < 1) { // no value found and adding values into table and creating array of id's
            $query = "INSERT INTO skill (`name`) VALUES ('$value')";
            try {
                mysqli_query($connection, $query) or throwException('cant insert skill');
            } catch (Exception $e) {
                echo $e->getMessage() . '<br>' . mysqli_error($connection) . '<br>';
                var_dump($e->getTrace()[0]);
                return false;
            }
            $skill_ids[] = mysqli_insert_id($connection);
        } else { // value found and creating array of id's
            $skill_ids[] = mysqli_fetch_assoc($result)['id'];
        }
    }
    $query = '';
    foreach ($skill_ids as $id) { //building queries
        $query .= "INSERT INTO user_has_skill (user_id,skill_id) VALUES ('$user_id',$id);";
    }

    try {
        mysqli_multi_query($connection, $query) or throwException('cant insert multi skill');
        do {
            $result = mysqli_store_result($connection);
            mysqli_free_result($result);
        } while (mysqli_next_result($connection));
    } catch (Exception $e) {
        echo $e->getMessage() . '<br>' . mysqli_error($connection) . '<br>';
        var_dump($e->getTrace()[0]);
        return false;
    }
    return true;

}

function insertEmploymentHistory($company, $start_date, $end_date, $reason, $user_id)
{
    if (empty($company)) { //is there any inputs
        return;
    }
    global $connection;
    $query = '';
    foreach ($company as $key => $value) { //looping employment history
        if ($value !== '') {
            $query .= "INSERT INTO `employment_history`(`user_id`, `company`, `start_date`, `end_date`, `reason`) VALUES ('$user_id','$value','$start_date[$key]','$end_date[$key]','$reason[$key]');";
        }
    }
    try {
        mysqli_multi_query($connection, $query) or throwException('cant insert multi company');

        do {
            $result = mysqli_store_result($connection);
            mysqli_free_result($result);
        } while (mysqli_next_result($connection));
    } catch (Exception $e) {
        echo $e->getMessage() . '<br>' . mysqli_error($connection) . '<br>';
        var_dump($e->getTrace()[0]);
        return false;
    }
    return true;
}