<?php
/**
 * Created by PhpStorm.
 * User: tyler.w.sriver
 * Date: 3/9/16
 * Time: 1:59 PM
 */
    $db_host = "173.194.86.153";
    $db_user = "pi";
    $db_password = "rn4R9EfAarJpY5VwY8rnBlL2";
    $db_database = "equipment";
    $con = new mysqli($db_host, $db_user, $db_password, $db_database);
    $sqlQuery = "SELECT `settings`.`units` FROM settings";
    $queryResult = mysqli_query($con,$sqlQuery);
    //echo $exec;
    $settings = array();
while($result = mysqli_fetch_array($queryResult)) {

    $settings = array('units' => $result['units']);
}

    //changes
    mysqli_close($con);
    echo json_encode($settings);

?>