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

//Connection for Temperature
$con = new mysqli($db_host, $db_user, $db_password, $db_database);
$sqlQuery =
    "(select * from temperature order by id desc limit 1) order by id asc"
    . "";
$exec = mysqli_query($con,$sqlQuery);

// Connection for Settings
$db_settingsDatabase = "equipment";
$settingsCon = new mysqli($db_host, $db_user, $db_password, $db_settingsDatabase);
$sqlQuerySettings = "SELECT `settings`.`units` FROM settings";
$execSetting = mysqli_query($settingsCon,$sqlQuerySettings);
$units = array();
while($result = mysqli_fetch_array($execSetting)) {
    $settings = array('units' => $result['units']);
}

$table = array();
$table = array(
    /* define your DataTable columns here
     * each column gets its own array
     * syntax of the arrays is:
     * label => column label
     * type => data type of column (string, number, date, datetime, boolean)
     */
    // I assumed your first column is a "string" type
    // and your second column is a "number" type
    // but you can change them if they are not
    array('label' => 'Air'),
    array('label' => 'Water')
);

$rows = array();

while($r = mysqli_fetch_array($exec)) {

    if($settings['units'] == 'C') {
        $r['air'] = ( $r['air'] - 32) / 1.8;
        $r['water'] = ($r['water'] - 32) / 1.8;
    }

    $table = array(
        /* define your DataTable columns here
         * each column gets its own array
         * syntax of the arrays is:
         * label => column label
         * type => data type of column (string, number, date, datetime, boolean)
         */
        // I assumed your first column is a "string" type
        // and your second column is a "number" type
        // but you can change them if they are not
        array('label' => 'Air', 'temp' =>  $r['air']),
        array('label' => 'Water', 'temp' => $r['water']),
        array('label' => '')
    );
}

// populate the table with rows of data

// encode the table as JSON
$jsonTable = json_encode($table);

mysqli_close($con);
mysqli_close($settingsCon);

echo json_encode($jsonTable);

?>