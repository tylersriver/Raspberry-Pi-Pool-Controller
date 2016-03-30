<?php

//Created by:
//
//Preston Kemp
//Tyler Sriver
//Embedded Systems Design SP2016
//
//Last Revision: 22 February 2016


$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "temp_database";
// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);
//$query=mysql_connect("localhost","root","");
//mysql_select_db("freeze",$query);
if(isset($_POST['value']))
{
    $value=$_POST['value'];

    if($value == 'off')
    {
        $gpio_on = shell_exec("/usr/local/bin/gpio -g write 25 0");
        echo "LED is off";
    }
    else
    {
        $gpio_on = shell_exec("/usr/local/bin/gpio -g write 25 1");
        echo "LED is on";
    }
    $query="update choice set choice='$value' where id='1'";
    $qresult = $mysqli->query($query);
    echo "<h2>You have Chosen the button status as:" .$value."</h2>";

}


?>