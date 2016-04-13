<?php
/**
 * Created by PhpStorm.
 * User: preston
 * Date: 3/6/16
 * Time: 8:43 PM
 */

$db_host = "173.194.86.153";
$db_user = "pi";
$db_password = "rn4R9EfAarJpY5VwY8rnBlL2";
$db_database = "equipment";
$con = new mysqli($db_host, $db_user, $db_password, $db_database);

$sql = "select * from schedule order by id desc limit 7";

$exec = mysqli_query($con,$sql);
$table = array();


$rows = array();
while($result = mysqli_fetch_array($exec)) {

    //$table = array('day' => $result['day'], 'start' => $result['start'], 'stop' => $result['stop']);
    // each column needs to have data inserted via the $temp array


    $temp[] = array('day' => $result['day'], 'start' => $result['start'], 'stop' => $result['stop'], 'setpoint' => $result['tempSetting']);

    // insert the temp array into $rows
//    $rows[] = array('c' => $temp);
}

// populate the table with rows of data
$table = $temp;
echo json_encode($table);

mysqli_close($con);



?>

