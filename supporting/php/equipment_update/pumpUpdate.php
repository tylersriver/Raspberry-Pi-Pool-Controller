<?php

//Created by:
//
//Preston Kemp
//Tyler Sriver
//Embedded Systems Design SP2016
//
//Last Revision: 22 February 2016

echo "function called";
$servername = "173.194.86.153";
$username = "pi";
$password = "rn4R9EfAarJpY5VwY8rnBlL2";
$dbname = "equipment";
// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);
//$query=mysql_connect("localhost","root","");
//mysql_select_db("freeze",$query);

// Connection for Settings
$db_settingsDatabase = "equipment";
;
$settingsCon = new mysqli($servername, $username, $password, $dbname);
$sqlQuerySettings = "(select * from heaterStatus order by id desc limit 1) order by id asc";
$execSetting = mysqli_query($settingsCon,$sqlQuerySettings);
while($result = mysqli_fetch_array($execSetting)) {
   $state = $result['state'];
    echo $state;
}

mysqli_close($settingsCon);


if(isset($_POST['value']))
{
    $value=$_POST['value'];

    if($value == "0")
    {
        //   $gpio_on = shell_exec("/usr/local/bin/gpio -g write 25 0");
        echo "Pump is off";
    }
    else
    {
        //  $gpio_on = shell_exec("/usr/local/bin/gpio -g write 25 1");
        echo "Pump is on";
    }
    $query="INSERT INTO status (datetime, pump, heater) VALUES (now(), $value, $state)";
   // $query="INSERT INTO status (datetime, pump, heater) VALUES (now(), 1 , 1)";
    echo "query executed";
    echo $query;
    $qresult = $mysqli->query($query);
    echo $qresult;
    mysqli_close($mysqli);
}

?>