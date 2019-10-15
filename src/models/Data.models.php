<?php
require_once '../../core/dbConnection.php';
require_once "../helpers/helpers.inc.php";

/**
 * @param $list
 * @return array|null
 */
function fetchList($list)
{
    global $connection;

    $query = "SELECT name FROM $list";
    try {
        $result = mysqli_query($connection, $query) or throwException('Cant fetch list');
        $array = mysqli_fetch_all($result);
    } catch (Exception $e) {
        echo $e->getMessage() .' '. mysqli_error($connection).'</br>';
        var_dump($e->getTrace()[0]);
    } finally {
        mysqli_free_result($result);
    }

    return $array;
}
/**
 * @param $data
 * @param $table
 * @param $filter
 * @return bool|mysqli_result
 */
function fetchData($data, $table, $filter)
{
    global $connection;
    $query = "select * from $table where $filter='$data'";
    try {
        $result = mysqli_query($connection, $query) or throwException('cant fetch data');
    } catch (Exception $e) {
        echo $e->getMessage() . '<br>' . mysqli_error($connection) . '<br>';
        var_dump($e->getTrace()[0]);
    }
    return $result;
}
/**
 * @return array
 */
function fetchUserInput()
{
    $user_input = array();
    foreach ($_POST['frm'] as $key => $value) {
        if (isset($_POST['frm'][$key])) {
            $user_input[$key] = $value;
        } else {
            $user_input[$key] = '';
        }
    }
    return $user_input;
}

function fetchCommaSeparatedData($data)
{
    $array = explode(',', $data);
    $none_empty_elements = array_filter($array, function ($element) {
        if (!ctype_space($element) && $element != '') {
            return $element;
        }
    });
    return $none_empty_elements;
}