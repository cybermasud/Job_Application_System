<?php
/* including database config */
require_once 'config.php';

try{
    $connection = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

    /* If there is an error with the connection, stop the script and display the error.*/
    if (mysqli_connect_errno()) {
        throw new Exception('connection Error');
    }
}catch (Exception $e){
    echo $e->getMessage().'<br>'.mysqli_connect_error();
}
