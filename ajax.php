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
//$query=mysql_connect("localhost","root","");
//mysql_select_db("freeze",$query);
if(isset($_POST['value']))
{
    $value=$_POST['value'];

    if($value == 0)
    {
     //   $gpio_on = shell_exec("/usr/local/bin/gpio -g write 25 0");
        echo "Heater is off";
    }
    else
    {
      //  $gpio_on = shell_exec("/usr/local/bin/gpio -g write 25 1");
        echo "Heater is on";
    }
    $query="INSERT INTO status (datetime, heater) VALUES (now(), $value)";
    $qresult = $mysqli->query($query);
    echo "<h2>You have Chosen the button status as:" .$value."</h2>";

}


?>