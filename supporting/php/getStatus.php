<?php
/**
 * Created by PhpStorm.
 * User: preston
 * Date: 3/6/16
 * Time: 8:43 PM
 */


function mysql_get_var($query,$y=0){
    $res = mysql_query($query);
    $row = mysql_fetch_array($res);
    mysql_free_result($res);
    $rec = $row[$y];
    return $rec;
}

$db_host = "173.194.86.153";
$db_user = "pi";
$db_password = "rn4R9EfAarJpY5VwY8rnBlL2";
$db_database = "equipment";
$con = new mysqli($db_host, $db_user, $db_password, $db_database);
$sql = "select * from status order by id desc limit 1";
$sqlQuery = "SELECT `settings`.`interrupt` FROM settings";

$queryResult = mysqli_query($con,$sqlQuery);
$exec = mysqli_query($con,$sql);

$settings = array();
while($data = mysqli_fetch_array($queryResult)) {

    $settings = array('manual' => $data['interrupt']);
}

$table = array();

while($result = mysqli_fetch_array($exec)) {
    $table = array(
        array('equipment' => 'pump', 'status' => $result['pump']),
        array('equipment' => 'heater', 'status' => $result['heater']),
        $settings
    );
}

$jsonTable = json_encode($table);
mysqli_close($con);
echo json_encode($jsonTable);


?>

