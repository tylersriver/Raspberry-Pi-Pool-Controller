<?php
/**
 * Created by PhpStorm.
 * User: preston
 * Date: 3/2/16
 * Time: 9:26 AM
 */

$db_host = "173.194.86.153";
$db_user = "pi";
$db_password = "rn4R9EfAarJpY5VwY8rnBlL2";
$db_database = "temp_database";
$con = new mysqli($db_host, $db_user, $db_password, $db_database);

$sqlQuery =
    "(select * from temperature order by id desc limit 60) order by id asc"
    . "";

$sqlQuery = "SELECT *
    FROM status 
WHERE CONVERT(DATETIME, FLOOR(CONVERT(FLOAT, datetime))) = date(\"Y/m/d\")";

$exec = mysqli_query($con,$sqlQuery);

// Connection for Settings
$db_settingsDatabase = "equipment";
$settingsCon = new mysqli($db_host, $db_user, $db_password, $db_settingsDatabase);
$units = array();
while($result = mysqli_fetch_array($execSetting)) {
    $settings = array('units' => $result['units']);
}


$table = array();
$table['cols'] = array(
    /* define your DataTable columns here
     * each column gets its own array
     * syntax of the arrays is:
     * label => column label
     * type => data type of column (string, number, date, datetime, boolean)
     */
    // I assumed your first column is a "string" type
    // and your second column is a "number" type
    // but you can change them if they are not
    array('label' => 'Time', 'type' => 'timeofday'),
    array('label' => 'Air Temperature', 'type' => 'number'),
    array('label' => 'Water Temperature', 'type' => 'number')
);

$rows = array();
while($r = mysqli_fetch_array($exec)) {

    if($settings['units'] == 'C') {
        $r['air'] = ( $r['air'] - 32) / 1.8;
        $r['water'] = ($r['water'] - 32) / 1.8;
    }

    $temp = array();
    // each column needs to have data inserted via the $temp array
    $time = explode(' ', $r['datetime']);
    // time assumes "hh:mm:ss" format
    $timeArr = explode(':', $time[1]);
    $timeArr[0] = $timeArr[0]+6;

    $temp[] = array('v' => $timeArr);
    $temp[] = array('v' => (float) $r['air']);
    $temp[] = array('v' => (float) $r['water']);

    // insert the temp array into $rows
    $rows[] = array('c' => $temp);
}

// populate the table with rows of data
$table['rows'] = $rows;

// encode the table as JSON
$jsonTable = json_encode($table);

mysqli_close($con);
mysqli_close($settingsCon);

echo json_encode($jsonTable);

?>