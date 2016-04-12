<?php

//Created by:
//
//Preston Kemp
//Tyler Sriver
//Embedded Systems Design SP2016
//
//Last Revision: 22 February 2016

$servername = "173.194.86.153";
$username = "pi";
$password = "rn4R9EfAarJpY5VwY8rnBlL2";
$dbname = "equipment";
// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

if(isset($_POST['value']))
{
    $value=$_POST['value'];

    if($value == "0")
    {
        //   $gpio_on = shell_exec("/usr/local/bin/gpio -g write 25 0");
        echo "Manual is off";
    }
    else
    {
        //  $gpio_on = shell_exec("/usr/local/bin/gpio -g write 25 1");
        echo "Manual is on";

    }

    $sqlQuery = "UPDATE settings SET interrupt ='{$value}' WHERE 1";
    $qresult = $mysqli->query($sqlQuery);
    mysqli_close($mysqli);
}
?>