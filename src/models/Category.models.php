<?php
//todo: functions to insert category or change them for users
require_once '../../core/dbConnection.php';

function fetchCategory()
{
    global $connection;
    $query = "SELECT * FROM `category`";
    try {
        $result = mysqli_query($connection, $query) or throwException('cant fetch');
    } catch (Exception $e) {
        $_SESSION['category_err'] = 'Something went Wrong';
        echo $e->getMessage() . '<br>' . mysqli_error($connection) . '<br>';
        var_dump($e->getTrace()[0]);
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function insertCategory($category)
{
    global $connection;
    $saved_category_string = userHasCategory(); //fetching saved before categories
    $saved_category_array = explode(',', $saved_category_string['id']);
    $category = array_diff($category, $saved_category_array); //deleting saved before categories
    if (empty($category)) {
        return;
    }
    $query = "";
    foreach ($category as $value) {
        $query .= "INSERT INTO `user_has_category` (`category_id`,`user_id`) VALUES ('$value','$_SESSION[user_id]');";
    }
    try {
        mysqli_multi_query($connection, $query) or throwException('cant insert multi category');

        do {
            $result = mysqli_store_result($connection);
            mysqli_free_result($result);
        } while (mysqli_next_result($connection));
    } catch (Exception $e) {
        $_SESSION['category_err'] = 'Something went Wrong';
        echo $e->getMessage() . '<br>' . mysqli_error($connection) . '<br>';
        var_dump($e->getTrace()[0]);
    }
    return;
}

function userHasCategory() //return a users selected fields
{
    global $connection;
    $sql = "SELECT `category_id` AS id FROM `user_has_category` WHERE `user_id`='$_SESSION[user_id]'";

    try {
        $result = mysqli_query($connection, $sql) or throwException('cant insert user category');
    } catch (Exception $e) {
        $_SESSION['category_err'] = 'Something went Wrong';
        echo $e->getMessage() . '<br>' . mysqli_error($connection) . '<br>';
        var_dump($e->getTrace()[0]);
        return false;
    }
    $user_category = mysqli_fetch_all($result, 1);
    if (!empty($user_category)) {
        return $user_category;
    }
    return false;
}

function fetchRelatedCompanies()
{
    global $connection;
    $category_id = userHasCategory();
    $ids='';
    foreach ($category_id as $key=>$value){
       if($key!==count($category_id)-1){
           $ids.=$value['id'].' OR ';
       }
    }
    $ids.=$category_id[count($category_id)-1]['id'];
    if (!$category_id) { //no category or error
        return;
    }
    $query = "SELECT
    COUNT(user_has_category.category_id) AS count,
    company_profile.name,
    company_profile.user_id,GROUP_CONCAT(category.name) as category
FROM
    `user_has_category`
JOIN company_profile ON user_has_category.user_id = company_profile.user_id
JOIN category ON user_has_category.category_id=category.id
WHERE
    user_has_category.category_id= $ids
GROUP BY
    user_has_category.user_id
    ORDER BY
    count
DESC";

    try {
        $result = mysqli_query($connection, $query) or throwException('cant fetch company');
    } catch (Exception $e) {
        echo $e->getMessage() . '<br>' . mysqli_error($connection) . '<br>';
        var_dump($e->getTrace()[0]);
        return false;
    }
    $companies=mysqli_fetch_all($result,1);
    if (mysqli_num_rows($result) > 0) {
        return $companies;
    }
    return;

}
