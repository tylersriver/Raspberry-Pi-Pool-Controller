<?php
/**
 * Created by PhpStorm.
 * User: preston
 * Date: 3/6/16
 * Time: 8:34 PM
 */

$db_host = "173.194.86.153";
$db_user = "pi";
$db_password = "rn4R9EfAarJpY5VwY8rnBlL2";
$db_database = "temp_database";
$con = new mysqli($db_host, $db_user, $db_password, $db_database);

$temp = $_POST['status'];
